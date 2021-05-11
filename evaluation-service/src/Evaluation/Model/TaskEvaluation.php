<?php

namespace App\Evaluation\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="task_evaluation")
 */
class TaskEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer", name="task_id")
     * @var int
     */
    private int $taskId;

    /**
     * @ORM\Column(type="integer", name="user_id")
     * @var int
     */
    private int $userId;

    /**
     * @ORM\OneToMany(targetEntity="App\Evaluation\Model\EvaluationAttempt", mappedBy="taskEvaluation", cascade={"persist"})
     * @var Collection|EvaluationAttempt[]
     */
    private Collection $attempts;

    /**
     * TaskEvaluation constructor.
     * @param int $taskId
     * @param int $userId
     */
    public function __construct(int $taskId, int $userId)
    {
        $this->setTaskId($taskId);
        $this->setUserId($userId);
        $this->attempts = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @param int $taskId
     */
    public function setTaskId(int $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return EvaluationAttempt[]|Collection
     */
    public function getAttempts(): Collection
    {
        return $this->attempts;
    }

    /**
     * @return EvaluationAttempt
     * @throws Exception
     */
    public function addAttempt(): EvaluationAttempt
    {
        $attempt = new EvaluationAttempt($this);
        $this->attempts->add($attempt);
        return $attempt;
    }
}