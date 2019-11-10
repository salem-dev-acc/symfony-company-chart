<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpClient\HttpClient;

class CompanyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $client = HttpClient::create();

        $response = $client->request('GET', 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');

        $content = $response->getContent();

        $companies = \json_decode($content, true);

        foreach ($companies as $company) {
            $entity = new Company();

            $entity->setName($company['Company Name'])
                ->setFinStatus($company['Financial Status'])
                ->setRoundLotSize($company['Round Lot Size'])
                ->setMarketCategory($company['Market Category'])
                ->setSecurityName($company['Security Name'])
                ->setSymbol($company['Symbol'])
                ->setTestIssue($company['Test Issue']);

            $manager->persist($entity);
        }

        $manager->flush();
    }
}
