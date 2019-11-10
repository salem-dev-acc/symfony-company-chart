<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @Route("/companies", name="company")
     * @inheritDoc
     */
    public function show(Request $request): JsonResponse
    {
        $symbol = $request->get('symbol', '');

        $company = $this->companyRepository->findOneBy([
            'symbol' => $symbol,
        ]);

        return $this->json([
            'is_valid' => ! is_null($company),
        ]);
    }
}
