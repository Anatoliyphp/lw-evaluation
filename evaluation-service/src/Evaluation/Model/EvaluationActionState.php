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
 * @ORM\Table(name="evaluation_action_state")
 */
class EvaluationActionState
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer", name="action_id")
     * @var int
     */
    private int $actionId;

    /**
     * @ORM\Column(type="smallint", name="status")
     * @var int
     */
    private int $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Evaluation\Model\EvaluationFileArtifact", mappedBy="evaluationActionState", cascade={"persist"})
     * @var Collection|EvaluationFileArtifact[]
     */
     private Collection $files;

    /**
     * @ORM\OneToMany(targetEntity="App\Evaluation\Model\EvaluationScoreArtifact", mappedBy="evaluationActionState", cascade={"persist"})
     * @var Collection|EvaluationScoreArtifact[]
     */
    private Collection $scores;

    /**
     * @ORM\OneToOne(targetEntity="App\Evaluation\Model\EvaluationCompilationArtifact", mappedBy="evaluationActionState", cascade={"persist"})
     * @var EvaluationCompilationArtifact|null
     */
    private ?EvaluationCompilationArtifact $compilation = null;

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
     * @ORM\ManyToOne(targetEntity="EvaluationAttempt", inversedBy="states")
     * @ORM\JoinColumn(name="evaluation_attempt_id", referencedColumnName="id")
     * @var EvaluationAttempt
     */
    private EvaluationAttempt $evaluationAttempt;

    /**
     * EvaluationActionState constructor.
     * @param int $actionId
     * @param EvaluationAttempt $evaluationAttempt
     * @throws Exception
     */
    public function __construct(int $actionId, EvaluationAttempt $evaluationAttempt)
    {
        $now = new DateTime();
        $this->setActionId($actionId);
        $this->setStatus(EvaluationStatus::IN_PROGRESS);
        $this->files = new ArrayCollection();
        $this->scores = new ArrayCollection();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->evaluationAttempt = $evaluationAttempt;
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
    public function getActionId(): int
    {
        return $this->actionId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @throws InvalidArgumentException
     */
    public function setStatus(int $status): void
    {
        if (!in_array($status, EvaluationStatus::getAvailableEvaluationStatuses())) {
            throw new InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    /**
     * @return EvaluationScoreArtifact[]|Collection
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    /**
     * @param string $fileName
     * @param $filePath
     * @return EvaluationFileArtifact
     * @throws Exception
     */
    public function addFile(string $fileName, $filePath): EvaluationFileArtifact
    {
        $file = new EvaluationFileArtifact($fileName, $filePath, $this);
        $this->files->add($file);
        return $file;
    }

    /**
     * @return EvaluationScoreArtifact[]|Collection
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    /**
     * @param int $score
     * @param int $passingScore
     * @param int $maxScore
     * @param int $evaluatedBy
     * @param string|null $comment
     * @return EvaluationScoreArtifact
     * @throws Exception
     */
    public function addScore(int $score, int $passingScore, int $maxScore, int $evaluatedBy, ?string $comment): EvaluationScoreArtifact
    {
        $scoreArtifact = new EvaluationScoreArtifact($score, $passingScore, $maxScore, $evaluatedBy, $this, $comment);
        $this->scores->add($scoreArtifact);
        return $scoreArtifact;
    }

    /**
     * @return EvaluationCompilationArtifact|null
     */
    public function getCompilation(): ?EvaluationCompilationArtifact
    {
        return $this->compilation;
    }

    /**
     * @param string|null $errorReason
     * @return EvaluationCompilationArtifact
     * @throws Exception
     */
    public function setCompilation(?string $errorReason): EvaluationCompilationArtifact
    {
        $compilation = new EvaluationCompilationArtifact($this, $errorReason);
        $this->compilation = $compilation;
        return $compilation;
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
     * @param int $actionId
     */
    private function setActionId(int $actionId): void
    {
        $this->actionId = $actionId;
    }

    /**
     * @param DateTime $createdAt
     */
    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}