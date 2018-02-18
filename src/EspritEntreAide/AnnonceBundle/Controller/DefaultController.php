<?php

namespace EspritEntreAide\AnnonceBundle\Controller;

use EspritEntreAide\AnnonceBundle\Entity\Annonce;
use EspritEntreAide\AnnonceBundle\Form\AnnonceType;
use EspritEntreAide\AnnonceBundle\Form\ChercherAnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AnnonceBundle:Default:index.html.twig');
    }

    public function afficheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("AnnonceBundle:Annonce")->findAll();
        return $this->render('AnnonceBundle::AfficherAnnonce.html.twig', array(
            "evts" => $evt
        ));

    }

    public function ajouterAnnonceAction(Request $request)
    {
        $an = new Annonce();
        // $an->setDateA();
        $form = $this->createForm(AnnonceType::class, $an);
        $form->handleRequest($request);//creation d'une session pr stocker les valeurs de l'input
        if ($form->isValid()) {
            $an->setIdUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($an);
            $em->flush();
            return $this->redirectToRoute('annonce_homepage');
        }
        return $this->render('AnnonceBundle::AjouterAnnonce.html.twig', array(
            'form' => $form->createView()
        ));
    }



    function chercherAnnonceAction(Request $request)
    {
        $an=new Annonce();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(ChercherAnnonceType::class,$an);
        $form->handleRequest($request);/*creation d'une session pr stocker les valeurs de l'input*/
        if($form->isValid()){

            $an=$em->getRepository("AnnonceBundle:Annonce")->findBy(array('titreA'=>$an->getTitreA()));

        }else{
            $an=$em->getRepository("AnnonceBundle:Annonce")->findAll();

        }

        return $this->render('AnnonceBundle::ChercherAnnonce.html.twig',array(
            'form'=>$form->createView(),'annonce'=>$an
        ));

    }


    function supprimerAnnonceAction(Request $request,$id){
        $an=$this->getDoctrine()->getManager();
        $annonce=$an->getRepository("AnnonceBundle:Annonce")->find($id);
        $form=$this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);
        $an->remove($annonce);
        $an->flush();
        return $this->redirectToRoute('_annonce_chercher');
    }


    public function modifierAnnonceAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $an = $em->getRepository(Annonce::class)->find($id);
        $an->setDateModif();
        $form = $this->createForm(AnnonceType::class, $an);
        $form->handleRequest($request);



        //Save?
        if($form->isValid()){
            $em->persist($an);
            $em->flush();
            return $this->redirectToRoute('_annonce_chercher');
        }
        // Recuperation des donnees
        //Remplir form
        return $this->render('AnnonceBundle::ModifierAnnonce.html.twig',array('form'=>$form->createView()));
        // .annonce..



    }

}
