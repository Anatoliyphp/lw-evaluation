<?php

namespace App\Enrollment\Api;

use Exception;

interface EnrollmentQueryServiceInterface
{
    /**
     * @param int $userId
     * @return array
     */
    public function listCoursesDataByUserId(int $userId): array;

    /**
     * @param int $userId
     * @param int $courseId
     * @return array
     */
    public function listLabWorksData(int $userId, int $courseId): array;

    /**
     * @param int $userId
     * @param int $taskId
     * @return bool
     * @throws Exception
     */
    public function isTaskAvailableToUser(int $userId, int $taskId): bool;
}