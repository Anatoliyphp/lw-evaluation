<?php
declare(strict_types=1);

namespace App\Evaluation\QueryService;

use App\Course\Model\EvaluationActionType;
use App\Evaluation\Api\EvaluationQueryServiceInterface;
use App\Evaluation\Model\EvaluationStatus;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use InvalidArgumentException;

class EvaluationQueryService implements EvaluationQueryServiceInterface
{
    /** @var Connection */
    private Connection $connection;

    /**
     * EvaluationQueryService constructor.
     * @param Connection $dbalConnection
     */
    public function __construct(Connection $dbalConnection )
    {
        $this->connection = $dbalConnection;
    }

    /**
     * @param int $userId
     * @param int $taskId
     * @return array
     * @throws Exception
     */
    public function getTaskState(int $userId, int $taskId): array
    {
        $pipeline = $this->getTaskPipeline($taskId);
        if (!$pipeline) {
            throw new InvalidArgumentException();
        }

        $lastAttemptId = $this->getLastEvaluationAttemptId($userId, $taskId);
        $fetchedStates = $lastAttemptId ? $this->getTaskStates($lastAttemptId) : [];
        return $this->getTaskEvaluationData($taskId, $pipeline, $fetchedStates);
    }

    /**
     * @param int $stateId
     * @return array
     * @throws Exception
     */
    private function getFiles(int $stateId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('evalFileArt.file_name as name', 'evalFileArt.file_path as url')
            ->from('evaluation_file_artifact', 'evalFileArt')
            ->where('evalFileArt.evaluation_action_state_id = :stateId')
            ->setParameter(':stateId', $stateId)
            ->join('evalFileArt', 'evaluation_action_state', 'evalActSt', 'evalFileArt.evaluation_action_state_id = evalActSt.id');
        $queryRes = $qb->execute()->fetchAll();
        return $queryRes ? $queryRes : [];
    }

    /**
     * @param int $taskId
     * @return array
     * @throws Exception
     */
    private function getTaskPipeline(int $taskId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('action.id as actionId', 'action.execution_order as `index`', 'action.type as type')
        ->from('task', 'task')
        ->where('task.id = :taskId')
        ->setParameter(':taskId', $taskId)
        ->join('task', 'evaluation_pipeline', 'evalPpl', 'task.pipeline_id = evalPpl.id')
        ->join('evalPpl', 'action', 'action', 'evalPpl.id = action.pipeline_id')
        ->orderBy('action.execution_order', 'ASC');
        $queryRes = $qb->execute()->fetchAll();
        return $queryRes ? $queryRes : [];
    }

    /**
     * @param int $userId
     * @param int $taskId
     * @return int|null
     * @throws Exception
     */
    private function getLastEvaluationAttemptId(int $userId, int $taskId): ?int
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('evalAtt.id as attemptId')
            ->from('task_evaluation', 'taskEval')
            ->where('taskEval.user_id = :userId')
            ->andWhere('taskEval.task_id = :taskId')
            ->setParameter(':userId', $userId)
            ->setParameter(':taskId', $taskId)
            ->join('taskEval', 'evaluation_attempt', 'evalAtt', 'taskEval.id = evalAtt.task_evaluation_id')
            ->addOrderBy('evalAtt.created_at', 'DESC')
            ->setMaxResults(1);
        $queryRes = $qb->execute()->fetchColumn(0);
        return $queryRes ? (int) $queryRes : null;
    }

    /**
     * @param int|null $lastAttemptId
     * @return array|null
     * @throws Exception
     */
    private function getTaskStates(?int $lastAttemptId): ?array
    {
        if (!$lastAttemptId) {
            return null;
        }

        $qb = $this->connection->createQueryBuilder();
        $qb->select('evalActSt.id as stateId', 'evalActSt.action_id as actionId', 'evalActSt.status as status')
            ->from('evaluation_attempt','evalAtt')
            ->where('evalAtt.id = :lastAttemptId')
            ->setParameter(':lastAttemptId', $lastAttemptId)
            ->join('evalAtt', 'evaluation_action_state', 'evalActSt', 'evalAtt.id = evalActSt.evaluation_attempt_id');
        $queryRes = $qb->execute()->fetchAll();
        return $queryRes ? $queryRes : null;
    }

    /**
     * @param int $taskId
     * @return array
     * @throws Exception
     */
    private function getTaskTitleAndDescription(int $taskId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('task.title as taskTitle', 'task.description as taskDescription')
            ->from('task')
            ->where('task.id = :taskId')
            ->setParameter(':taskId', $taskId);
        $queryRes = $qb->execute()->fetch();
        return $queryRes ? $queryRes : [];
    }

    /**
     * @param int $actionId
     * @param array|null $states
     * @return array|null
     */
    private function getStateFromStates(int $actionId, ?array $states): ?array
    {
        if (!$states) {
            return null;
        }

        foreach ($states as $state) {
            if ($actionId == $state['actionId']) {
                return [
                    'status' => $state['status'],
                    'stateId' => $state['stateId']
                ];
            }
        }
        return null;
    }

    /**
     * @param array $action
     * @param array|null $state
     * @return array
     * @throws Exception
     */
    private function arrangeState(array $action, ?array $state): array
    {
        $arrangedState = [
            'index' => $action['index'],
            'actionId' => $action['actionId'],
            'type' => $action['type']
         ];
        if ($state){
            $arrangedState['status'] = $state['status'];
        }
        if ($state && $action['type'] == EvaluationActionType::FILE_UPLOAD) {
            $arrangedState['files'] = $this->getFiles((int) $state['stateId']);
            // TODO get url from path
        }
        return $arrangedState;
    }

    /**
     * @param int $taskId
     * @param array $pipeline
     * @param array|null $states
     * @return array
     * @throws Exception
     */
    private function getTaskEvaluationData(int $taskId, array $pipeline, ?array $states): array
    {
        $taskStates = [];
        foreach ($pipeline as $action) {
            $state = $this->getStateFromStates((int) $action['actionId'], $states);
            $state = $this->arrangeState($action, $state);
            $taskStates[] = $state;
            if (!array_key_exists('status', $state) || $state['status'] != EvaluationStatus::COMPLETED) {
                break;
            }
        }

        $states = [];
        foreach ($taskStates as $state){
            $states[] = [
                'index' => $state['index'],
                'id' => $state['actionId'],
                'type' => $state['type'],
                'state' => array_key_exists('status', $state) ? $state['status'] : EvaluationStatus::IN_PROGRESS,
                'files' => array_key_exists('files', $state) ? $state['files'] : []
            ];
        }
        $taskInfo = $this->getTaskTitleAndDescription($taskId);
        $taskState = [
            'taskTitle' => $taskInfo['taskTitle'],
            'taskDescription' => $taskInfo['taskDescription'],
            'lastActionId' => end($taskStates)['actionId'],
            'actions' => $states
        ];

        return $taskState;
    }
}
