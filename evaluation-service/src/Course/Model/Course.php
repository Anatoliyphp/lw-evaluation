<?php

namespace App\Course\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="course")
 */
class Course
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
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="CourseTeacherId", mappedBy="course", cascade={"persist"})
     * @var CourseTeacherId[]
     */
    private $teacherIds;

    /**
     * @ORM\OneToMany(targetEntity="EvaluationPipeline", mappedBy="course", cascade={"persist"})
     * @var EvaluationPipeline[]
     */
    private $pipelines;

    /**
     * @ORM\OneToMany(targetEntity="App\Course\Model\LabWork", mappedBy="course", cascade={"persist"})
     * @var LabWork[]
     */
    private $labWorks;

    public function __construct($title, $description)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->teacherIds = new ArrayCollection();
        $this->pipelines = new ArrayCollection();
        $this->labWorks = new ArrayCollection();
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

    /**
     * @return CourseTeacherId[]
     */
    public function getTeacherIds(): array
    {
        return $this->teacherIds;
    }

    public function addTeacherId(int $teacherId): void
    {
        $courseTeacherId = new CourseTeacherId($teacherId, $this);
        foreach ($this->teacherIds as $teacherID) {
            if ($teacherID->getTeacherId() == $teacherId) {
                throw new InvalidArgumentException("This teacher already added");
            }
        }
        $this->teacherIds->add($courseTeacherId);
    }

    /**
     * @return EvaluationPipeline[]
     */
    public function getPipelines(): array
    {
        return $this->pipelines;
    }

    public function createPipeline(): EvaluationPipeline
    {
        $pipeline = new EvaluationPipeline($this);
        $this->pipelines->add($pipeline);
        return $pipeline;
    }

    /**
     * @return LabWork[]
     */
    public function getLabWorks(): array
    {
        return $this->labWorks;
    }

    /**
     * @param LabWork[] $labWorks
     */
    public function setLabWorks(array $labWorks): void
    {
        $this->labWorks = $labWorks;
    }

    public function isLabWorkPresent(string $title): bool
    {
        foreach ($this->labWorks as $lw) {
            if ($lw->getTitle() == $title) {
                return true;
            }
        }
        return false;
    }

    public function getLabWorkById(int $labWorkId): ?labWork
    {
        foreach ($this->labWorks as $lw) {
            if ($lw->getId() == $labWorkId) {
                return $lw;
            }
        }
        return null;
    }

    public function getLabWorkByTitle($labWorkTitle): ?labWork
    {
        foreach ($this->labWorks as $lw) {
            if ($lw->getTitle() == $labWorkTitle) {
                return $lw;
            }
        }
        return null;
    }

    public function addLabWork(string $title): void
    {
        $lw = new LabWork($title, $this);
        $this->labWorks->add($lw);
    }

    public function updateLabWorkTitle(int $labWorkId, string $newTitle): void
    {
        foreach ($this->labWorks as $lw) {
            if ($lw->getId() == $labWorkId) {
                $lw->setTitle($newTitle);
                return;
            }
        }
        throw new InvalidArgumentException("This labwork doesn't exist");
    }
}
