<?php

namespace App\Controller;

use App\DTO\CompanyFormFilter;
use App\Form\CompanyFormFilterType;
use App\Service\CompanyApiService;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @inheritDoc
     */
    public function index(Request $request, CompanyApiService $companyService, Mailer $mailer): Response
    {
        $form = $this->createForm(CompanyFormFilterType::class, new CompanyFormFilter());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();

            $response = $companyService->getValues($formData);

            if (! $response) {
                $form->get('symbol')->addError(new FormError('Symbol can not be found'));

                return $this->render('welcome.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $mailer->send(
                $formData->getEmail(),
                'name',
                'emails/company_graph.html.twig',
                [
                    'start_date' => $formData->getStartDate(),
                    'end_date' => $formData->getEndDate(),
                ]
            );

            return $this->render('company_graph.html.twig', [
                'data' => $response['dataset']['data'] ?? [],
            ]);
        }

        return $this->render('welcome.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
