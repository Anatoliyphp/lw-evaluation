<?php

namespace App\Course\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */

class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=65535)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $passingScore;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $maxScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $pipelineId;

    /**
     * @ORM\ManyToOne(targetEntity="LabWork", inversedBy="tasks")
     * @ORM\JoinColumn(name="lab_work_id", referencedColumnName="id")
     */
    private $labWork;

    public function __construct($title, $description, $passingScore, $maxScore, $pipelineId, LabWork $labWork)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPassingScore($passingScore);
        $this->setMaxScore($maxScore);
        $this->setPipelineId($pipelineId);
        $this->labWork = $labWork;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPassingScore(): int
    {
        return $this->passingScore;
    }

    public function setPassingScore(int $passingScore): void
    {
        $this->passingScore = $passingScore;
    }

    public function getMaxScore(): int
    {
        return $this->maxScore;
    }

    public function setMaxScore(int $maxScore): void
    {
        $this->maxScore = $maxScore;
    }

    public function getLabWork(): LabWork
    {
        return $this->labWork;
    }

    public function getPipelineId(): int
    {
        return $this->pipelineId;
    }

    public function setPipelineId(int $pipelineId): void
    {
        $this->pipelineId = $pipelineId;
    }
}