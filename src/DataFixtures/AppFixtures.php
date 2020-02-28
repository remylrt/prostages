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
        $listeFormations = array();
        $listeEntreprises = array();

        //Création des données pour la table Formation
        $dutinfo->setNom("Diplome Universitaire de Technologie Informatique");
        $dutinfo->setSigle("DUT Informatique");
        array_push($listeFormations, $dutinfo);
        $manager->persist($dutinfo);

        $duttic->setNom("Diplome Universitaire de Technologie Technologie de l'Information et de la Communication");
        $duttic->setSigle("DUT TIC");
        array_push($listeFormations, $duttic);
        $manager->persist($duttic);

        $licenceMulti->setNom("Licence professionnelle Multimedia");
        $licenceMulti->setSigle("LP Multimedia");
        array_push($listeFormations, $licenceMulti);
        $manager->persist($licenceMulti);        

        //Génération des données pour la table Entreprise
        for ($i=0; $i < 10; $i++) { 
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setSite($faker->domainName);
            $entreprise->setActivite($faker->jobTitle);
            $entreprise->setTel($faker->regexify('0[1-5][0-9]{8}'));
            array_push($listeEntreprises,$entreprise);
            $manager->persist($entreprise);
        }
        
        //Génération des données pour la table Stage
        for ($i=0; $i < 30; $i++) { 
            $stage = new Stage;
            $formations = array_rand($listeFormations, $faker->numberBetween(1,3));
            $stage->setTitre($faker->catchPhrase);
            $stage->setMail($faker->companyEmail);
            $stage->setDescription($faker->realText($maxNbChars = 255, $indexSize = 2));
            $entrepriseStage = $faker->randomElement($array = $listeEntreprises);
            $stage->setEntreprise($entrepriseStage);
            $entrepriseStage->addStage($stage);

            foreach ($formations as $formation) {
                $stage->addFormation($formation);
                $formation->addStage($stage);
            }

            $manager->persist($entrepriseStage);
            $manager->persist($stage);
        }

        $manager->flush();
    }
}
