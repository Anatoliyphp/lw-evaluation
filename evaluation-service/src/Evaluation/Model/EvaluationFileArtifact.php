<?php

namespace App\Evaluation\Model;

use DateTime;
use Exception;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="evaluation_file_artifact")
 */
class EvaluationFileArtifact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, name="file_name")
     * @var string
     */
    private string $fileName;

    /**
     * @ORM\Column(type="text", name="file_path")
     * @var string
     */
    private string $filePath;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="EvaluationActionState", inversedBy="files")
     * @ORM\JoinColumn(name="evaluation_action_state_id", referencedColumnName="id")
     * @var EvaluationActionState
     */
    private EvaluationActionState $evaluationActionState;

    /**
     * EvaluationFileArtifact constructor.
     * @param string $fileName
     * @param string $filePath
     * @param EvaluationActionState $evaluationActionState
     * @throws Exception
     */
    public function __construct(string $fileName, string $filePath, EvaluationActionState $evaluationActionState)
    {
        $now = new DateTime();
        $this->setFileName($fileName);
        $this->setFilePath($filePath);
        $this->setCreatedAt($now);
        $this->evaluationActionState = $evaluationActionState;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $fileName
     * @throws InvalidArgumentException
     */
    private function setFileName(string $fileName): void
    {
        $strLength = strlen($fileName);
        if ($strLength === 0 || $strLength > 255) {
            throw new InvalidArgumentException("Invalid file name");
        }
        $this->fileName = $fileName;
    }

    /**
     * @param string $filePath
     */
    private function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @param DateTime $createdAt
     */
    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}