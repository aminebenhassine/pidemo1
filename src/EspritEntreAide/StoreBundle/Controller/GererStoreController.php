<?php

namespace EspritEntreAide\StoreBundle\Controller;

use EspritEntreAide\StoreBundle\Entity\Store;
use EspritEntreAide\StoreBundle\Form\StoreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GererStoreController extends Controller
{

    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $stores=$em->getRepository("StoreBundle:Store")->findAll();

        return $this->render("@Store/Default/index.html.twig",array(
            'stores'=>$stores
        ));
    }

    public function AjoutStoreAction(Request $request)
    {
        $st = new Store();
        $form = $this->createForm(StoreType::class, $st);
        $form->handleRequest($request);/*creation d'une session pr stocker les valeurs de l'input*/
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($st);
            $em->flush();
        }
        return $this->render('@Store/Default/ajoutStore.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function removeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $store=$em->getRepository("StoreBundle:Store")->find($id);
        if ($store!=null){
            $em->remove($store);
            $em->flush();
        }
        return $this->redirectToRoute("store_homepage");
    }

    public function editAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $store=$em->getRepository("StoreBundle:Store")->find($id);
        $form=$this->createForm(StoreType::class,$store);
        $form->handleRequest($request);
        if ($request->isMethod("POST")){
            $em->flush();
        }

        return $this->render("StoreBundle:Default:editStore.html.twig",array(
           'form'=>$form->createView()
        ));
    }

    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $storeName=$request->request->get('storeName');
        $storeManager=$request->request->get('storeManager');

        $stores=$em->getRepository("StoreBundle:Store")->createQueryBuilder("s")
            ->select("s.nomStore,s.id")
            ->innerJoin("s.user","u")
            ->where("s.nomStore like '%$storeName%'")
            ->AndWhere("u.username like '%$storeManager%'")
            ->getQuery()
            ->getResult()
        ;

        return new JsonResponse($stores);

    }

}
