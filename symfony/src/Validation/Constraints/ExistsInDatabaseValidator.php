<?php

namespace App\Validation\Constraints;

use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExistsInDatabaseValidator extends ConstraintValidator
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function validate($value, Constraint $constraint)
    {

        $company = $this->companyRepository->findBy([
            'symbol' => $value,
        ]);

        if (! $company) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        return true;
    }
}
