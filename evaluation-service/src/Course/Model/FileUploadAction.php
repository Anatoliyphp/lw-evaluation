<?php

namespace App\Course\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="file_upload_action")
 */
class FileUploadAction extends BaseEvaluationAction
{

    /**
     * @ORM\OneToMany(targetEntity="FileUploadActionFileType", mappedBy="file_upload_action", cascade={"persist"})
     * @var FileUploadActionFileType[]
     */
    private $acceptableFileTypes;

    public function __construct()
    {
        $this->acceptableFileTypes = new ArrayCollection();
    }

    /**
     * @return FileUploadActionFileType[]
     */
    public function getFileTypes(): array
    {
        return $this->acceptableFileTypes;
    }

    public function addFileType(string $fileType): void
    {
        $acceptableType = new FileUploadActionFileType($fileType, $this);
        foreach ($this->acceptableFileTypes as $acceptableFileType) {
            if ($acceptableFileType->getType() == $fileType) {
                throw new InvalidArgumentException("This file type already exists");
            }
        }
        $this->acceptableFileTypes->add($acceptableType);
    }

    public function getType(): int
    {
        return EvaluationActionType::FILE_UPLOAD;
    }

    public function getFileUploadAction(): FileUploadAction
    {
        return $this;
    }

}