<?php

namespace App\User\Model;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    const ROLE_STUDENT = 1;
    const ROLE_TEACHER = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $groupId;

    /**
     * @param string $email
     * @param string $password
     * @param int $role
     * @param string $firstName
     * @param string $lastName
     * @throws InvalidArgumentException
     */
    public function __construct(string $email, string $password, int $role, string $firstName, string $lastName)
    {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @throws InvalidArgumentException
     */
    public function setEmail(string $email): void
    {
        if (!preg_match("/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/", $email)) {
            throw new InvalidArgumentException("Invalid email");
        }
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->getEmail();
    }

    /**
     * @return string Returns encoded password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password Set encoded password
     * @see PasswordEncoderInterface
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // do nothing
    }

    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @throws InvalidArgumentException
     */
    public function setRole(int $role): void
    {
        if (!in_array($role, array(self::ROLE_STUDENT, self::ROLE_TEACHER))) {
            throw new InvalidArgumentException("Invalid status");
        }
        $this->role = $role;
    }

    public function getRoles(): array
    {
        return $this->getRole() === self::ROLE_STUDENT ? ['ROLE_STUDENT'] : ['ROLE_TEACHER'];
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @throws InvalidArgumentException
     */
    public function setFirstName(string $firstName): void
    {
        $strLength = strlen($firstName);
        if ($strLength === 0 || $strLength > 255) {
            throw new InvalidArgumentException("Invalid firstName");
        }
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @throws InvalidArgumentException
     */
    public function setLastName(string $lastName): void
    {
        $strLength = strlen($lastName);
        if ($strLength === 0 || $strLength > 255) {
            throw new InvalidArgumentException("Invalid lastName");
        }
        $this->lastName = $lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroup(Group $group): void
    {
        $this->groupId = $group->getId();
    }
}
