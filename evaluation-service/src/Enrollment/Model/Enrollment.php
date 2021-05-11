<?php

namespace App\Enrollment\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="enrollment")
 */
class Enrollment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer", name="user_id")
     * @var int
     */
    private int $userId;

    /**
     * @ORM\Column(type="integer", name="course_id")
     * @var int
     */
    private int $courseId;

    /**
     * @ORM\OneToMany(targetEntity="App\Enrollment\Model\LabWorkAvailability", mappedBy="enrollment", cascade={"persist"})
     * @var Collection|LabWorkAvailability[]
     */
    private Collection $labWorks;

    /**
     * Enrollment constructor.
     * @param int $userId
     * @param int $courseId
     */
    public function __construct(int $userId, int $courseId)
    {
        $this->setUserId($userId);
        $this->setCourseId($courseId);
        $this->labWorks = new ArrayCollection();
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->courseId;
    }

    /**
     * @param int $courseId
     */
    public function setCourseId(int $courseId): void
    {
        $this->courseId = $courseId;
    }

    /**
     * @return LabWorkAvailability[]|Collection
     */
    public function getLabWorks(): array
    {
        return $this->labWorks;
    }

    /**
     * @param LabWorkAvailability[]|Collection $labWorks
     */
    public function setLabWorks(array $labWorks): void
    {
        $this->labWorks = $labWorks;
    }

    /**
     * @param $labWorkId
     * @param DateTime $accessDate
     * @throws InvalidArgumentException
     * @return LabWorkAvailability
     */
    public function addLabWorkAvailability($labWorkId, DateTime $accessDate): LabWorkAvailability
    {
        $lwAvailability = new LabWorkAvailability($labWorkId, $accessDate, $this);
        foreach ($this->labWorks as $availability) {
            if ($availability->getLabWorkId() == $labWorkId) {
                throw new InvalidArgumentException("This labWorkAvailability already exists");
            }
        }
        $this->labWorks->add($lwAvailability);
        return $lwAvailability;
    }

    /**
     * @param $labWorkId
     * @param DateTime $accessDate
     */
    public function updateLabWorkAvailability($labWorkId, DateTime $accessDate): void
    {
        foreach ($this->labWorks as $availability) {
            if ($availability->getLabWorkId() == $labWorkId) {
                $availability->setAccessDate($accessDate);
                return;
            }
        }
        throw new InvalidArgumentException("This labWorkAvailability doesn't exist");
    }
}