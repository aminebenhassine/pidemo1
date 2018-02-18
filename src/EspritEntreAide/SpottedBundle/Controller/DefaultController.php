<?php

namespace EspritEntreAide\SpottedBundle\Controller;

use Doctrine\ORM\Mapping\Id;
use EspritEntreAide\SpottedBundle\Entity\Commentaire;
use EspritEntreAide\SpottedBundle\Entity\Publication;
use EspritEntreAide\SpottedBundle\Form\CommentaireType;
use EspritEntreAide\SpottedBundle\Form\PublicationType;
use EspritEntreAide\SpottedBundle\Form\RechercheType;
use EspritEntreAide\UserBundle\Entity\User;
use FOS\UserBundle\FOSUserBundle;
use FOS\UserBundle\Model\User as Seif;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SpottedBundle:Default:index.html.twig');
    }


    public function fooAction()
    {

    }

    public function ajoutAction(Request $request)
    {
        //return new Response($this->getUser());
        //return new Response($this->getUser()->getId());
        $publication = new Publication();
        $em= $this->getDoctrine()->getManager();
        $form=$this->createForm("EspritEntreAide\SpottedBundle\Form\PublicationType",$publication);
        $form->handleRequest($request);


        if ($form->isValid())
        {



            $current_user_id_bySeif = $this->getUser()->getId();

            $publication->setIdUser($this->getUser());
            $em->persist($publication);
            $em->flush();

            $em2 = $this->getDoctrine()->getManager();
           $this->redirectToRoute('_list_spotted');

        }
        return $this->render("@Spotted/CRUD/ajout.html.twig",array(
            'form'=>$form->createView()
        ));
    }

    public function listSpottedAction(Request $request)
    {


        $publication = new Publication();
        $em=$this->getDoctrine()->getManager();

        $listspotted = $em->getRepository("SpottedBundle:Publication",$publication)->findAll();


        return $this->render("@Spotted/CRUD/listspotted.html.twig",array(
            'listspotted'=>$listspotted

        ));
    }
    public function modifSpottedAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository("SpottedBundle:Publication")->find($id);
        $Form = $this->createForm(PublicationType::class, $publication);

        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $this->redirectToRoute('_list_spotted');

        }
        return $this->render('@Spotted/CRUD/modif.html.twig', array(
            "form"=>$Form->createview()
        ));
    }

    public function contentSpottedAction(Request $request,$id)
    {


        $publication = new Publication();
        $em=$this->getDoctrine()->getManager();

        $listspotted = $em->getRepository("SpottedBundle:Publication",$publication)->findBy(array('id'=>$id));
        $lst = $em->getRepository("SpottedBundle:Publication",$publication)->findOneBy(['id' => $id]);


        $commentaire = new Commentaire();
        $em=$this->getDoctrine()->getManager();

        $lstcomments = $em->getRepository("SpottedBundle:Commentaire",$commentaire)->findBy(array('idPublication'=>$id));



        //return new Response($this->getUser());
        //return new Response($this->getUser()->getId());
        $commentaire = new Commentaire();
        $em= $this->getDoctrine()->getManager();
        $form=$this->createForm("EspritEntreAide\SpottedBundle\Form\CommentaireType",$commentaire);
        $form->handleRequest($request);


        if ($form->isValid())
        {
            $commentaire->setIdUser($this->getUser());
            $commentaire->setIdPublication($lst);



            $em->persist($commentaire);
            $em->flush();

            $em2 = $this->getDoctrine()->getManager();


        }



        return $this->render("@Spotted/CRUD/content.html.twig",array(
            'listspotted'=>$listspotted,
            'form'=>$form->createView(),
            'comments'=>$lstcomments

        ));
    }


    public function editCommentSpottedAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("SpottedBundle:Commentaire")->find($id);
        $Form = $this->createForm(CommentaireType::class, $commentaire);

        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('_list_spotted');

        }
        return $this->render('@Spotted/CRUD/modifcomment.html.twig', array(
            "form"=>$Form->createview()
        ));
    }


    public function deleteSpottedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository("SpottedBundle:Publication")->find($id);
        $em->remove($publication);
        $em->flush();
        return $this->redirectToRoute('_list_spotted');
    }


    public function deleteCommentSpottedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("SpottedBundle:Commentaire")->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('_list_spotted');
    }

    public function RechercheAction(Request $request){
        $voiture=new Publication();
        $em=$this->getDoctrine()->getManager();
        $Form=$this->createForm(RechercheType::class,$voiture);
        $Form->handleRequest($request);
        if($request->isXmlHttpRequest() ){

            $ser=$request->get('s');

            $voiture=$em->getRepository("SpottedBundle:Publication")->findBy(array('titreP'=>$ser));
            $serialzier = new Serializer(array(new ObjectNormalizer()));
            $v = $serialzier->normalize($voiture);

            return new JsonResponse($v);

        }
        else{
            $voiture=$em->getRepository("SpottedBundle:Publication")->findAll();

        }
        return $this->render("SpottedBundle:Default:rechercher.html.twig",array(
                'Form'=>$Form->createView(),
            'voitures'=>$voiture
        ));

    }

}
