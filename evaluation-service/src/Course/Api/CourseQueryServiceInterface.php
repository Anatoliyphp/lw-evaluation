<?php

namespace App\Course\Api;

interface CourseQueryServiceInterface
{
    public function listTasks(int $userId, int $labWork_id): array;

    public function getLabWorkTitle(int $labWork_id): ?string;
}