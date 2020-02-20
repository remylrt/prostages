<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProstagesController extends AbstractController{

    public function index(){
        return $this->render("prostages/index.html.twig");
    }

    public function entreprises(){
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprises = $repositoryEntreprise->findAll();

        return $this->render("prostages/entreprises.html.twig", ['entreprises' => $entreprises]);
    }

    public function formations(){
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formations = $repositoryFormation->findAll();

        return $this->render("prostages/formations.html.twig", ['formations' => $formations]);
    }

    public function stages(){
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stages = $repositoryStage->findAll();
        return $this->render("prostages/stages.html.twig", ['stages'=>$stages]);
    }

    public function ajouterEntreprise(Request $requetteHttp, ObjectManager $manager){
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this->createFormBuilder($entreprise)
                                    ->add('nom')
                                    ->add('activite')
                                    ->add('adresse')
                                    ->add('site', TextType::class, ['label'=>'Site web'])
                                    ->add('tel', TextType::class, ['label'=>'Numéro de téléphone'])
                                    ->getForm();
                                    
        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
        }
        
        return $this->render("prostages/ajouterEntreprise.html.twig", ['vueFormulaireEntreprise'=>$formulaireEntreprise->createView()]);
    }

    public function modifierEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise){
        $formulaireEntreprise = $this->createFormBuilder($entreprise)
                                    ->add('nom')
                                    ->add('activite')
                                    ->add('adresse')
                                    ->add('site', TextType::class, ['label'=>'Site web'])
                                    ->add('tel', TextType::class, ['label'=>'Numéro de téléphone'])
                                    ->getForm();
                                    
        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
        }
        
        return $this->render("prostages/modifierEntreprise.html.twig", ['vueFormulaireEntreprise'=>$formulaireEntreprise->createView()]);
    }
                                
    /*public function stages($id){
        return $this->render("prostages/stages.html.twig", ['idStage'=>$id]);
    }*/
}
