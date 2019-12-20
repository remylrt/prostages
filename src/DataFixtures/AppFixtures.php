<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $entreprise = new Entreprise();
        $entreprise->setNom("Capgemini");
        $entreprise->setAdresse("Rue Joseph Szydlowski, 64100 Bayonne");
        $entreprise->setSite("www.capgemini.com");
        $entreprise->setActivite("ESN");
        $entreprise->setTel("0533783300");
        $manager->persist($entreprise);

        $manager->flush();
    }
}
