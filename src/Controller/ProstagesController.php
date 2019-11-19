<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProstagesController extends AbstractController{

    public function index(){
        return $this->render("prostages/index.html.twig");
    }

    public function entreprises(){
        return $this->render("prostages/entreprises.html.twig");
    }

    public function formations(){
        return $this->render("prostages/formations.html.twig");
    }

    public function stages($id){
        return $this->render("prostages/stages.html.twig", ['idStage'=>$id]);
    }
}
