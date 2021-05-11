<?php

namespace App\Course\QueryService;

use App\Course\Api\CourseQueryServiceInterface;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class CourseQueryService implements CourseQueryServiceInterface
{
    /** @var Connection */
    private Connection $connection;

    public function __construct(Connection $dbalConnection)
    {
        $this->connection = $dbalConnection;
    }

    /**
     * @param int $userId
     * @param int $labWork_id
     * @return array
     * @throws Exception
     */
    public function listTasks(int $userId, int $labWork_id): array
    {
        $date = new DateTime();
        $qb = $this->connection->createQueryBuilder();
        $qb->select('t.id', 't.title', 't.max_score')
            ->from('enrollment', 'e')
            ->where('e.user_id = :user')
            ->where('lwa.lab_work_id = :id')
            ->andWhere('lwa.access_date <= :date')
            ->setParameter('user', $userId)
            ->setParameter('id', $labWork_id)
            ->setParameter('date', $date->format("Y-m-d H:i:s"))
            ->join('e', 'lab_work_availability', 'lwa', 'e.id = lwa.enrollment_id')
            ->join('lwa', 'lab_work', 'lw', 'lwa.lab_work_id = lw.id')
            ->join('lw', 'task', 't', 'lw.id = t.lab_work_id')
            ->groupBy('t.id');
        return $qb->execute()->fetchAll();
    }

    /**
     * @param int $labWork_id
     * @return string
     * @throws Exception
     */
    public function getLabWorkTitle(int $labWork_id): ?string
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('lw.title as labWorkTitle')
            ->from('lab_work', 'lw')
            ->where('lw.id = :id')
            ->setParameter('id', $labWork_id);
        $labWork = $qb->execute()->fetchAll();
        if ($labWork){
            return $labWork[0]['labWorkTitle'];
        }
        return null;
    }
}