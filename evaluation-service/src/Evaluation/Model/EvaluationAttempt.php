<?php

namespace App\Evaluation\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="evaluation_attempt")
 */
class EvaluationAttempt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="smallint", name="final_status")
     * @var int
     */
    private int $finalStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Evaluation\Model\EvaluationActionState", mappedBy="evaluationAttempt", cascade={"persist"})
     * @var Collection|EvaluationActionState[]
     */
    private Collection $states;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var DateTime
     */
    private DateTime $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="TaskEvaluation", inversedBy="attempts")
     * @ORM\JoinColumn(name="task_evaluation_id", referencedColumnName="id")
     * @var TaskEvaluation
     */
    private TaskEvaluation $taskEvaluation;

    /**
     * EvaluationAttempt constructor.
     * @param TaskEvaluation $taskEvaluation
     * @throws Exception
     */
    public function __construct(TaskEvaluation $taskEvaluation)
    {
        $now = new DateTime();
        $this->setFinalStatus(EvaluationStatus::IN_PROGRESS);
        $this->states = new ArrayCollection();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->taskEvaluation = $taskEvaluation;
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
    public function getFinalStatus(): int
    {
        return $this->finalStatus;
    }

    /**
     * @param int $finalStatus
     * @throws InvalidArgumentException
     */
    public function setFinalStatus(int $finalStatus): void
    {
        if (!in_array($finalStatus, EvaluationStatus::getAvailableEvaluationStatuses())) {
            throw new InvalidArgumentException("Invalid final status");
        }
        $this->finalStatus = $finalStatus;
    }

    /**
     * @return EvaluationActionState[]|Collection
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    /**
     * @param int $actionId
     * @return EvaluationActionState
     * @throws Exception
     */
    public function addState(int $actionId): EvaluationActionState
    {
        $state = new EvaluationActionState($actionId, $this);
        $this->states->add($state);
        return $state;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param DateTime $createdAt
     */
    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}