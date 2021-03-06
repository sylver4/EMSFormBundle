<?php

declare(strict_types=1);

namespace EMS\FormBundle\Submission;

use EMS\FormBundle\Components\Field\File;
use EMS\FormBundle\Components\Field\MultipleFile;
use EMS\FormBundle\FormConfig\FormConfig;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FormData
{
    /** @var FormConfig */
    private $formConfig;
    /** @var array */
    private $raw;

    public function __construct(FormConfig $formConfig, FormInterface $form)
    {
        $this->formConfig = $formConfig;

        $formData = $form->getData();
        $this->raw = \is_array($formData) ? $formData : [];
    }

    public function raw(): array
    {
        return $this->raw;
    }

    public function getAllFiles(): array
    {
        $files = [];

        foreach ($this->raw as $formField => $value) {
            $element = $this->formConfig->getElementByName($formField);

            if (null === $element || !\in_array($element->getClassName(), [MultipleFile::class, File::class])) {
                continue;
            }

            $uploadedFiles = \is_array($value) ? $value : [$value];

            foreach ($uploadedFiles as $uploadedFile) {
                if ($uploadedFile instanceof UploadedFile) {
                    $files[] = new FormDataFile($uploadedFile, $element);
                }
            }
        }

        return $files;
    }
}
