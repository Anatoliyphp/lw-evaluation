<?php

namespace App\Evaluation\Model;

use DateTime;
use Exception;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="evaluation_score_artifact")
 */
class EvaluationScoreArtifact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer", name="score")
     * @var integer
     */
    private int $score;

    /**
     * @ORM\Column(type="integer", name="passing_score")
     * @var integer
     */
    private int $passingScore;

    /**
     * @ORM\Column(type="integer", name="max_score")
     * @var integer
     */
    private int $maxScore;

    /**
     * @ORM\Column(type="integer", name="evaluated_by_id")
     * @var integer
     */
    private int $evaluatedById;

    /**
     * @ORM\Column(type="text", name="comment", nullable=true)
     * @var string|null
     */
    private ?string $comment;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="EvaluationActionState", inversedBy="scores")
     * @ORM\JoinColumn(name="evaluation_action_state_id", referencedColumnName="id")
     * @var EvaluationActionState
     */
    private EvaluationActionState $evaluationActionState;

    /**
     * EvaluationScoreArtifact constructor.
     * @param int $score
     * @param int $passingScore
     * @param int $maxScore
     * @param int $evaluatedById
     * @param EvaluationActionState $evaluationActionState
     * @param string|null $comment
     * @throws Exception
     */
    public function __construct(
        int $score,
        int $passingScore,
        int $maxScore,
        int $evaluatedById,
        EvaluationActionState $evaluationActionState,
        ?string $comment
    ) {
        $now = new DateTime();
        $this->setScore($score);
        $this->setPassingScore($passingScore);
        $this->setMaxScore($maxScore);
        $this->setEvaluatedById($evaluatedById);
        $this->setCreatedAt($now);
        $this->evaluationActionState = $evaluationActionState;
        $this->setComment($comment);
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
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getPassingScore(): int
    {
        return $this->passingScore;
    }

    /**
     * @param int $passingScore
     */
    public function setPassingScore(int $passingScore): void
    {
        $this->passingScore = $passingScore;
    }

    /**
     * @return int
     */
    public function getMaxScore(): int
    {
        return $this->maxScore;
    }

    /**
     * @param int $maxScore
     */
    public function setMaxScore(int $maxScore): void
    {
        $this->maxScore = $maxScore;
    }

    /**
     * @return int
     */
    public function getEvaluatedById(): int
    {
        return $this->evaluatedById;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param int $evaluatedById
     */
    private function setEvaluatedById(int $evaluatedById): void
    {
        $this->evaluatedById = $evaluatedById;
    }

    /**
     * @param DateTime $createdAt
     */
    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}