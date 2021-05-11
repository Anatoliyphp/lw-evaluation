<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="course_teacher_id")
 */

 class CourseTeacherId
 {

     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $teacherId;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="teacherIds")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course; 

    public function __construct(int $teacherId, Course $course)
    {
        $this->setTeacherId($teacherId);
        $this->course = $course;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function setTeacherId(int $teacherId): void
    {
        $this->teacherId= $teacherId;
    }
}