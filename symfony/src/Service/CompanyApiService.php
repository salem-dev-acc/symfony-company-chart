<?php

namespace App\Service;

use App\DTO\CompanyFormFilter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class CompanyApiService
{
    public function getValues(CompanyFormFilter $formData): ?array
    {
        try {
            $url = sprintf('%s/%s.json?', $_ENV['QUANDL_API'], $formData->getSymbol());

            $params = http_build_query([
                'order' => 'asc',
                'start_date' => $formData->getStartDate(),
                'end_date' => $formData->getEndDate(),
            ]);

            $response = HttpClient::create()->request(
                'GET',
                $url . $params
            );

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                return null;
            }

            return $response->toArray();

        } catch (\Throwable $e) {
            return null;
        }
    }
}
