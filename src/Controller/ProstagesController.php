<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Formation;

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

    public function stages($id){
        return $this->render("prostages/stages.html.twig", ['idStage'=>$id]);
    }
}
