<?php

namespace EspritEntreAide\StoreBundle\Controller;

use EspritEntreAide\StoreBundle\Entity\Demande;
use EspritEntreAide\StoreBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function indexStoreAction()
    {
        $em=$this->getDoctrine()->getManager();
        $demandes=$em->getRepository("StoreBundle:Demande")->findBy(array("idStore"=>$this->getUser()->getStore()));
        return $this->render('StoreBundle:Demande:indexStore.html.twig',array(
            'demandes'=>$demandes
        ));
    }

    public function indexTeacherAction()
    {
        $em=$this->getDoctrine()->getManager();
        $demandes=$em->getRepository("StoreBundle:Demande")->findby(array("idUser"=>$this->getUser()));
        return $this->render('StoreBundle:Demande:indexTeacher.html.twig',array(
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

    public function adminSearchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $date=$request->request->get('date');
        $store=$request->request->get('store');
        $teacher=$request->request->get('teacher');

        $demande=$em->getRepository("StoreBundle:Demande")->createQueryBuilder("d")
            ->select("d.nbrCopie,d.id,d.dateCreation,s.nomStore,u.username")
            ->innerJoin("d.idUser","u")
            ->innerJoin("d.idStore","s")
            ->where("s.nomStore like '%$store%'")
            ->AndWhere("u.username like '%$teacher%'")
            ->AndWhere("d.dateCreation like '%$date%'")
            ->getQuery()
            ->getResult()
        ;

        return new JsonResponse($demande);
    }

    public function storeSearchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $date=$request->request->get('date');
        $teacher=$request->request->get('teacher');

        $demande=$em->getRepository("StoreBundle:Demande")->createQueryBuilder("d")
            ->select("d.nbrCopie,d.id,d.dateCreation,s.nomStore,u.username")
            ->innerJoin("d.idUser","u")
            ->innerJoin("d.idStore","s")
            ->AndWhere("u.username like '%$teacher%'")
            ->AndWhere("d.dateCreation like '%$date%'")
            ->getQuery()
            ->getResult()
        ;

        return new JsonResponse($demande);
    }

    public function teacherSearchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $date=$request->request->get('date');
        $store=$request->request->get('store');

        $demande=$em->getRepository("StoreBundle:Demande")->createQueryBuilder("d")
            ->select("d.nbrCopie,d.id,d.dateCreation,s.nomStore,u.username")
            ->innerJoin("d.idUser","u")
            ->innerJoin("d.idStore","s")
            ->where("s.nomStore like '%$store%'")
            ->AndWhere("d.dateCreation like '%$date%'")
            ->getQuery()
            ->getResult()
        ;

        return new JsonResponse($demande);
    }

    public function changeEtatAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("StoreBundle:Demande")->find($id);

        if ($demande->getEtatDemande()=="En cours"){
            $demande->setEtatDemande("Prête");
        }else{
            $demande->setEtatDemande("En cours");
        }
        $em->flush();
        return $this->redirectToRoute("demande_index_store");
    }

    public function detailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("StoreBundle:Demande")->find($id);

        return $this->render("@Store/Demande/detail.html.twig",array(
            'demande'=>$demande
        ));
    }

}