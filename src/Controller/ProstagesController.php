<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Form\EntrepriseType;
use App\Form\StageType;

class ProstagesController extends AbstractController{

    public function index(){
        return $this->render("prostages/index.html.twig");
    }

    public function entreprises(){
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprises = $repositoryEntreprise->findAll();

        return $this->render("prostages/entreprises.html.twig", ['entreprises' => $entreprises]);
    }

    public function detailsEntreprise($nomEntreprise){
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $entreprise = $repositoryEntreprise->findOneBy(['nom'=> $nomEntreprise]);
        $stages = $repositoryStage->findByEntreprise($nomEntreprise);

        return $this->render("prostages/detailsEntreprise.html.twig", ['entreprise'=>$entreprise, 'stages'=>$stages]);
    }

    public function formations(){
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formations = $repositoryFormation->findAll();

        return $this->render("prostages/formations.html.twig", ['formations' => $formations]);
    }

    public function detailsFormation($nomFormation){
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $formation = $repositoryFormation->findOneBy(['nom'=> $nomFormation]);
        $stages = $repositoryStage->findByFormation($nomFormation);

        return $this->render("prostages/detailsFormation.html.twig", ['formation'=>$formation, 'stages'=>$stages]);
    }

    public function stages(){
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stages = $repositoryStage->findAll();
        
        return $this->render("prostages/stages.html.twig", ['stages'=>$stages]);
    }

    public function detailsStage($idStage){
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stage = $repositoryStage->findOneBy(['id'=> $idStage]);

        return $this->render("prostages/detailsStage.html.twig", ['stage'=>$stage]);
    }

    public function ajouterEntreprise(Request $requetteHttp, ObjectManager $manager){
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
                                    
        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
        }
        
        return $this->render("prostages/ajouterEntreprise.html.twig", ['vueFormulaireEntreprise'=>$formulaireEntreprise->createView()]);
    }

    public function modifierEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise){
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
                                    
        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
        }
        
        return $this->render("prostages/modifierEntreprise.html.twig", ['vueFormulaireEntreprise'=>$formulaireEntreprise->createView()]);
    }

    public function ajouterStage(Request $requetteHttp, ObjectManager $manager){
        $stage = new Stage();

        $formulaireStage = $this->createForm(StageType::class, $stage);
                                    
        $formulaireStage->handleRequest($requetteHttp);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
            $manager->persist($stage);
            $manager->flush();
        }
        
        return $this->render("prostages/ajouterStage.html.twig", ['vueFormulaireStage'=>$formulaireStage->createView()]);
    }

    /*public function stages($id){
        return $this->render("prostages/stages.html.twig", ['idStage'=>$id]);
    }*/
}
