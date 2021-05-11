<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pascal_compilation_action")
 */

 class PascalCompilationAction extends BaseEvaluationAction
 {

     /**
     * @ORM\Column(type="integer")
     * @var int
     */
     private $actionIdToCompile;

     public function __construct(int $actionIdToCompile)
     {
        $this->setActionIdToCompile($actionIdToCompile);
     }

     public function getActionIdToCompile(): int
     {
        return $this->actionIdToCompile;
     }

    public function setActionIdToCompile(int $actionIdToCompile): void
    {
        $this->actionIdToCompile = $actionIdToCompile;
    }

    public function getType(): int
    {
        return EvaluationActionType::PASCAL_COMPILATION;
    }

    public function getPascalCompilationAction(): PascalCompilationAction
    {
        return $this;
    }
 }