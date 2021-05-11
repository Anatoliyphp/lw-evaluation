<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="evaluation_pipeline")
 */

class EvaluationPipeline
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="pipelines")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="BaseEvaluationAction", mappedBy="evaluation_pipeline", cascade={"persist"})
     * @var BaseEvaluationAction[]
     */
    private $actions;

    public function __construct(Course $course)
    {
        $this->actions = new ArrayCollection();
        $this->course = $course;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    /**
     * @return BaseEvaluationAction[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function addAction(BaseEvaluationAction $action): void
    {
        $action->setPipeline($this);
        $action->setExecutionOrder($this->actions->count());
        $this->actions->add($action);
    }
}