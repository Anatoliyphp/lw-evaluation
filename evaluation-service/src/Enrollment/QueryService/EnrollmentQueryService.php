<?php
declare(strict_types=1);

namespace App\Enrollment\QueryService;

use App\Enrollment\Api\EnrollmentQueryServiceInterface;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class EnrollmentQueryService implements EnrollmentQueryServiceInterface
{
    /** @var Connection */
    private Connection $connection;

    /**
     * EnrollmentQueryService constructor.
     * @param Connection $dbalConnection
     */
    public function __construct(Connection $dbalConnection ) {
        $this->connection = $dbalConnection;
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function listCoursesDataByUserId(int $userId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('e.course_id', 'c.title', 'c.description')
            ->from('enrollment', 'e')
            ->where('e.user_id = ?')
            ->setParameter(0, $userId)
            ->join('e', 'course', 'c', 'e.course_id = c.id');
        $res = $qb->execute()->fetchAll();
        return $res;
    }

    /**
     * @param int $userId
     * @param int $courseId
     * @return array
     * @throws Exception
     */
    public function listLabWorksData(int $userId, int $courseId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('c.title as courseTitle', 'c.description as courseDescription', 'lw.id', 'lw.title', 'SUM(t.max_score) as maxScore')
            ->from('enrollment', 'e')
            ->where('e.user_id = ?')
            ->andWhere('e.course_id = ?')
            ->andWhere('lwa.access_date <= ?')
            ->setParameter(0, $userId)
            ->setParameter(1, $courseId)
            ->setParameter(2, (new DateTime())->format('Y-m-d h:i:s'))
            ->join('e', 'course', 'c', 'c.id = e.course_id' )
            ->join('e', 'lab_work_availability', 'lwa', 'e.id = lwa.enrollment_id')
            ->join('lwa', 'lab_work', 'lw', 'lwa.lab_work_id = lw.id')
            ->join('lw', 'task', 't', 'lw.id = t.lab_work_id')
            ->groupBy('lw.id');
        $res = $qb->execute()->fetchAll();
        return $res;
    }

    /**
     * @param int $userId
     * @param int $taskId
     * @return bool
     * @throws Exception
     */
    public function isTaskAvailableToUser(int $userId, int $taskId): bool
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('t.id', 'lwa.access_date')
            ->from('task','t')
            ->where('e.user_id = :userId')
            ->andWhere('t.id = :taskId')
            ->andWhere('lwa.access_date <= :accessDate')
            ->setParameter(':userId', $userId)
            ->setParameter(':taskId', $taskId)
            ->setParameter(':accessDate', (new DateTime())->format('Y-m-d h:i:s'))
            ->join('t', 'lab_work', 'lw', 't.lab_work_id = lw.id')
            ->join('lw', 'course', 'c', 'lw.course_id = c.id')
            ->join('c', 'enrollment', 'e', 'c.id = e.course_id')
            ->join('lw', 'lab_work_availability', 'lwa', 'lw.id = lwa.lab_work_id');
        $res = $qb->execute()->fetchAll();
        return count($res) > 0;
    }
}
