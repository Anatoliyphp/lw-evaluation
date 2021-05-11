<?php

namespace App\User\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setName(string $name): self
    {
        $strLength = strlen($name);
        if ($strLength === 0 || $strLength > 255) {
            throw new InvalidArgumentException("Invalid groupName");
        }
        $this->name = $name;
        return $this;
    }
}
