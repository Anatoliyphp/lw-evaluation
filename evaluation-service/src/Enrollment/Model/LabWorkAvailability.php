<?php

namespace App\Enrollment\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lab_work_availability")
 */

class LabWorkAvailability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="lab_work_id")
     * @var int
     */
    private $labWorkId;

    /**
     * @ORM\Column(type="datetime", name="access_date")
     * @var DateTime
     */
    private DateTime $accessDate;

    /**
     * @ORM\ManyToOne(targetEntity="Enrollment", inversedBy="labWorks")
     * @ORM\JoinColumn(name="enrollment_id", referencedColumnName="id")
     */
    private $enrollment;

    /**
     * LabWorkAvailability constructor.
     * @param $labWorkId
     * @param DateTime $accessDate
     * @param Enrollment $enrollment
     */
    public function __construct($labWorkId, DateTime $accessDate, Enrollment $enrollment)
    {
        $this->setLabWorkId($labWorkId);
        $this->setAccessDate($accessDate);
        $this->enrollment = $enrollment;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getAccessDate(): DateTime
    {
        return $this->accessDate;
    }

    /**
     * @param DateTime $accessDate
     */
    public function setAccessDate(DateTime $accessDate): void
    {
        $this->accessDate = $accessDate;
    }

    /**
     * @return int
     */
    public function getLabWorkId(): int
    {
        return $this->labWorkId;
    }

    /**
     * @param int $labWorkId
     */
    public function setLabWorkId(int $labWorkId): void
    {
        $this->labWorkId = $labWorkId;
    }

    /**
     * @return Enrollment
     */
    public function getEnrollment(): Enrollment
    {
        return $this->enrollment;
    }
}