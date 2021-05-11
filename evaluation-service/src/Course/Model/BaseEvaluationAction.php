<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="action")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 * EvaluationActionType::FILE_UPLOAD = "FileUploadAction",
 * EvaluationActionType::PASCAL_COMPILATION = "PascalCompilationAction",
 * EvaluationActionType::TEACHER_EVALUATION = "TeacherEvaluationAction"
 * })
 */
abstract class BaseEvaluationAction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="EvaluationPipeline", inversedBy="actions")
     * @ORM\JoinColumn(name="pipeline_id", referencedColumnName="id")
     */
    private $pipeline;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $executionOrder;

    public function setExecutionOrder(int $order)
    {
        $this->executionOrder = $order;
    }

    public function getExecutionOrder(): ?int
    {
        return $this->executionOrder;
    }

    public function setPipeline(EvaluationPipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileUploadAction(): ?FileUploadAction
    {
        return null;
    }

    public function getTeacherEvaluationAction(): ?TeacherEvaluationAction
    {
        return null;
    }

    public function getPascalCompilationAction(): ?PascalCompilationAction
    {
        return null;
    }

    abstract public function getType(): int;
}