<?php

namespace EspritEntreAide\ClubBundle\Controller;

use EspritEntreAide\ClubBundle\Entity\Club;
use EspritEntreAide\ClubBundle\Form\ClubType;
use EspritEntreAide\ClubBundle\Form\Recherchetype;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class gererclubController extends Controller
{

    public function AjoutAction(Request $request)
    {
        $cl = new Club();
        $form = $this->createForm(ClubType::class, $cl);
        $form->handleRequest($request);/*creation d'une session pr stocker les valeurs de l'input*/
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cl);
            $em->flush();
        }
        return $this->render('@Club/Default/ajoutclub.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function AfficheAction()
    {
        $cl = $this->getDoctrine()->getManager();
        $club = $cl->getRepository("ClubBundle:Club")->findAll();
        return $this->render('@Club/Default/afficheclub.html.twig', array(
            "club" => $club
            // ...
        ));
    }


    function RechercheAction(Request $request)
    {
        $cl=new Club();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(Recherchetype::class,$cl);
        $form->handleRequest($request);/*creation d'une session pr stocker les valeurs de l'input*/
        if($form->isValid()){

            $cl=$em->getRepository("ClubBundle:Club")->findBy(array('nomC'=>$cl->getNomC()));

        }else{
            $cl=$em->getRepository("ClubBundle:Club")->findAll();

        }

        return $this->render('@Club/Default/recherche.html.twig',array(
            'form'=>$form->createView(),'club'=>$cl
        ));

    }



    function DeleteAction(Request $request,$id){
        $cl=$this->getDoctrine()->getManager();
        $club=$cl->getRepository("ClubBundle:Club")->find($id);
        $form=$this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        $cl->remove($club);
        $cl->flush();
        return $this->redirectToRoute('club_recherche');
    }




    public function ModifierAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $cl = $em->getRepository(club::class)->find($id);

        $form = $this->createForm(ClubType::class, $cl);
        $form->handleRequest($request);

        if($form->isValid()){
            $em->persist($cl);
            $em->flush();
            return $this->redirectToRoute('club_recherche');
        }

        return $this->render('@Club/Default/modifclub.html.twig',array('form'=>$form->createView()));
    }

    public function ajouterMembresAction(){
        $em = $this->getDoctrine()->getManager();
        $id=$_GET['id'];
        $cl = $em->getRepository("ClubBundle:Club")->find($id);
        $Membres=$this->getUser();
        $cl->addMembres($Membres);
        $em->persist($cl);
        $em->flush();
        return $this->redirectToRoute('club_affiche');
    }





}
