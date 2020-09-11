<?php

declare(strict_types=1);

namespace EMS\FormBundle\Components\Constraint;

use EMS\FormBundle\Service\Confirmation\ConfirmationService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsVerificationCodeValidator extends ConstraintValidator
{
    /** @var ConfirmationService */
    private $confirmationService;

    public function __construct(ConfirmationService $confirmationService)
    {
        $this->confirmationService = $confirmationService;
    }

    /**
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || !$constraint instanceof IsVerificationCode) {
            return;
        }

        if (null === $confirmValue = $this->getConfirmValue($constraint)) {
            return;
        }

        /** @var FormInterface $field */
        $field = $this->context->getObject();
        $verificationCode = $this->confirmationService->getVerificationCode($field->getName(), $confirmValue);

        if (null === $verificationCode) {
            $this->context->addViolation($constraint->messageMissing);
            return;
        }

        if ($verificationCode !== (string) $value) {
            $this->context->addViolation($constraint->message, ['{{code}}' => $value]);
        }
    }

    private function getConfirmValue(IsVerificationCode $constraint): ?string
    {
        /** @var FormInterface $form */
        $form = $this->context->getRoot();

        if (!$form instanceof FormInterface) {
            return null;
        }

        $data = $form->getData();

        if (!is_array($data)) {
            return null;
        }

        return $data[$constraint->field] ?? null;
    }
}
