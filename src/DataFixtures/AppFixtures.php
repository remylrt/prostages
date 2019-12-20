<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $dutinfo = new Formation;
        $duttic = new Formation;
        $licenceMulti = new Formation;

        //Génération des données pour la table Entreprise
        for ($i=0; $i < 10; $i++) { 
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setSite($faker->domainName);
            $entreprise->setActivite($faker->jobTitle);
            $entreprise->setTel($faker->regexify('0[1-5][0-9]{8}'));
            $manager->persist($entreprise);
        }
        
        //Génération des données pour la table Stage
        for ($i=0; $i < 30; $i++) { 
            $stage = new Stage;
            $stage->setTitre($faker->catchPhrase);
            $stage->setMail($faker->companyEmail);
            $stage->setDescription($faker->realText($maxNbChars = 255, $indexSize = 2));
            $manager->persist($stage);
        }

        //Création des données pour la table Formation
        $dutinfo->setNom("Diplome Universitaire de Technologie Informatique");
        $dutinfo->setSigle("DUT Informatique");
        $manager->persist($dutinfo);

        $duttic->setNom("Diplome Universitaire de Technologie Technologie de l'Information et de la Communication");
        $duttic->setSigle("DUT TIC");
        $manager->persist($duttic);

        $licenceMulti->setNom("Licence professionnelle Multimedia");
        $licenceMulti->setSigle("LP Multimedia");
        $manager->persist($licenceMulti);

        $manager->flush();
    }
}
