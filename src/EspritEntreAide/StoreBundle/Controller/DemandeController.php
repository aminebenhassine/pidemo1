<?php

namespace EspritEntreAide\StoreBundle\Controller;

use EspritEntreAide\StoreBundle\Entity\Demande;
use EspritEntreAide\StoreBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemandeController extends Controller{

    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $demandes=$em->getRepository("StoreBundle:Demande")->findAll();
        return $this->render('StoreBundle:Demande:index.html.twig',array(
            'demandes'=>$demandes
        ));
    }

    public function newAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=new Demande();
        $document=new Document();
        $form=$this->createForm("EspritEntreAide\StoreBundle\Form\DemandeType",$demande);
        $formDocument=$this->createForm("EspritEntreAide\StoreBundle\Form\DocumentType",$document);
        $form->handleRequest($request);
        $formDocument->handleRequest($request);
        if ($request->isMethod("POST")){
            $em->persist($document);
            $demande->addDocument($document);
            $demande->setIdUser($this->getUser());
            $em->persist($demande);
            $em->flush();
        }

        return $this->render('StoreBundle:Demande:new.html.twig',array(
            'form'=>$form->createView(),
            'formDocument'=>$formDocument->createView()
        ));
    }

    public function removeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("StoreBundle:Demande")->find($id);
        if ($demande!=null){
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute("demande_index");
    }
}