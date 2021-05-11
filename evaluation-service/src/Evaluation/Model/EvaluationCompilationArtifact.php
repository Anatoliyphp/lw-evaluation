<?php

namespace App\Evaluation\Model;

use DateTime;
use Exception;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="evaluation_compilation_artifact")
 */
class EvaluationCompilationArtifact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="text", name="error_reason", nullable=true)
     * @var string|null
     */
    private ?string $errorReason;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="EvaluationActionState", inversedBy="compilation")
     * @ORM\JoinColumn(name="evaluation_action_state_id", referencedColumnName="id")
     * @var EvaluationActionState
     */
    private EvaluationActionState $evaluationActionState;

    /**
     * EvaluationCompilationArtifact constructor.
     * @param EvaluationActionState $evaluationActionState
     * @param string|null $errorReason
     * @throws Exception
     */
    public function __construct(EvaluationActionState $evaluationActionState, ?string $errorReason)
    {
        $now = new DateTime();
        $this->setCreatedAt($now);
        $this->evaluationActionState = $evaluationActionState;
        $this->setErrorReason($errorReason);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getErrorReason(): ?string
    {
        return $this->errorReason;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $errorReason
     */
    private function setErrorReason(?string $errorReason): void
    {
        $this->errorReason = $errorReason;
    }

    /**
     * @param DateTime $createdAt
     */
    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}