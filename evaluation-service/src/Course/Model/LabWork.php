<?php

namespace App\Course\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lab_work")
 */

class LabWork
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
     * @ORM\OneToMany(targetEntity="App\Course\Model\Task", mappedBy="labWork")
     * @var Task[]
     */
    private $tasks;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="labWorks")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * LabWork constructor.
     * @param $title
     * @param $tasks
     * @param Course $course
     */
    public function __construct($title, Course $course)
    {
        $this->setTitle($title);
        $this->tasks = new ArrayCollection();
        $this->course = $course;
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

    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @param Task[] $tasks
     */
    public function setTasks(array $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function isTaskPresent($title): bool
    {
        foreach ($this->tasks as $task) {
            if ($task->getTitle() == $title) {
                return true;
            }
        }
        return false;
    }

    public function getTaskByTitle(string $taskTitle): ?Task
    {
        foreach ($this->tasks as $task) {
            if ($task->getTitle() == $taskTitle) {
                return $task;
            }
        }
        return null;
    }

    public function addTask(string $title, string $description, int $passingScore, int $maxScore, int $pipelineId): void
    {
        $task = new Task($title, $description, $passingScore, $maxScore, $pipelineId, $this);
        $this->tasks->add($task);
    }
}