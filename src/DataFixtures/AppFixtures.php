<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Création des utilisateurs de test
        $remy = new User();
        $remy->setNom('Lartiguelongue');
        $remy->setPrenom('Remy');
        $remy->setUsername('remy');
        $remy->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $remy->setPassword('$2y$10$0AveBAFN7dt3j0.2AUFiQeHwnG8bFrdpNMRyYTDDmxllvAYbO6hTi');//russia
        $manager->persist($remy);

        $lama = new User();
        $lama->setNom('Lama');
        $lama->setPrenom('Michel');
        $lama->setUsername('lama');
        $lama->setRoles(['ROLE_USER']);
        $lama->setPassword('$2y$10$J/SkLTirXRBoX576xxH4BOzG58jwWtazaisymCcWbl4cjhvdZ6TNq');//lama
        $manager->persist($lama);

        $faker = \Faker\Factory::create('fr_FR');
        $dutinfo = new Formation;
        $duttic = new Formation;
        $licenceMulti = new Formation;
        $listeFormations = array();
        $listeEntreprises = array();

        //Création des données pour la table Formation
        $dutinfo->setNom("Diplome Universitaire de Technologie Informatique");
        $dutinfo->setSigle("DUT Info");
        array_push($listeFormations, $dutinfo);
        $manager->persist($dutinfo);

        $duttic->setNom("Diplome Universitaire de Technologie Technologie de l'Information et de la Communication");
        $duttic->setSigle("DUT TIC");
        array_push($listeFormations, $duttic);
        $manager->persist($duttic);

        $licenceMulti->setNom("Licence professionnelle Multimedia");
        $licenceMulti->setSigle("LP Multi");
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
            $formation = new Formation();
            $formation = $listeFormations[array_rand($listeFormations)];    
            $stage->setTitre($faker->jobTitle);
            $stage->setMail($faker->companyEmail);
            $stage->setDescription($faker->realText($maxNbChars = 255, $indexSize = 2));
            $entrepriseStage = $faker->randomElement($array = $listeEntreprises);
            $stage->setEntreprise($entrepriseStage);
            $entrepriseStage->addStage($stage);

            $stage->addFormation($formation);
            $formation->addStage($stage);

            $manager->persist($entrepriseStage);
            $manager->persist($stage);
        }

        $manager->flush();
    }
}
