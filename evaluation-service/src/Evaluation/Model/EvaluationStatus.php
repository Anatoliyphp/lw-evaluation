<?php

namespace App\Evaluation\Model;

class EvaluationStatus
{
    public const IN_PROGRESS = 1;
    public const COMPLETED = 2;
    public const ERROR = 3;

    /**
     * @return array<int>
     */
    public static function getAvailableEvaluationStatuses(): array
    {
        return [
            self::IN_PROGRESS,
            self::COMPLETED,
            self::ERROR
        ];
    }
}