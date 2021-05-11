<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use App\Course\Model\BaseEvaluationAction;
use App\Course\Model\EvaluationActionType;

/**
 * @ORM\Entity
 * @ORM\Table(name="teacher_evaluation_action")
 */

 class TeacherEvaluationAction extends BaseEvaluationAction
 {

     /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $actionId;

    public function __construct(int $actionId)
    {
        $this->setActionId($actionId);
    }

    public function getActionId(): int
    {
        return $this->actionId;
    }

    public function setActionId(int $actionId): void
    {
        $this->actionId = $actionId;
    }

    public function getType(): int
    {
        return EvaluationActionType::TEACHER_EVALUATION;
    }

    public function getTeacherEvaluationAction(): TeacherEvaluationAction
    {
        return $this;
    }

}