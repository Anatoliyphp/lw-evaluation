<?php

namespace App\Evaluation\Api;

use Exception;

interface EvaluationQueryServiceInterface
{
    /**
     * @param int $userId
     * @param int $taskId
     * @return array
     * @throws Exception
     */
    public function getTaskState(int $userId, int $taskId): array;
}