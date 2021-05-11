<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="file_upload_file_type")
 */

class FileUploadActionFileType
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Course\Model\FileUploadAction", inversedBy="acceptabelFileTypes", cascade={"persist"})
     * @ORM\JoinColumn(name="file_upload_action_id", referencedColumnName="id")
     */
    private $fileUploadAction;

    public function __construct(string $type, FileUploadAction $fileUploadAction)
    {
        $this->setType($type);
        $this->fileUploadAction = $fileUploadAction;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}