<?php

namespace EspritEntreAide\EvenementBundle\Controller;

use EspritEntreAide\EvenementBundle\Entity\Evenement;
use EspritEntreAide\EvenementBundle\Form\Evenement2Type;
use EspritEntreAide\EvenementBundle\Form\EvenementAdminType;
use EspritEntreAide\EvenementBundle\Form\EvenementType;
use EspritEntreAide\EvenementBundle\Form\ModiferEvtType;
use EspritEntreAide\EvenementBundle\Form\ModiferImgEvtType;
use EspritEntreAide\EvenementBundle\Form\RechercheClubType;
use EspritEntreAide\EvenementBundle\Form\RechercheDateType;
use EspritEntreAide\EvenementBundle\Form\RechercheNomType;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Ivory\GoogleMap\Service\Place\Base\Place;
use Ivory\GoogleMapBundle\Form\Type\PlaceAutocompleteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends Controller
{
    public function ajoutAction(Request $request)
    {
        $evt = new Evenement();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            or $this->get('security.authorization_checker')->isGranted('ROLE_RESPONSABLE_SUPER_ADMIN')
            or $this->get('security.authorization_checker')->isGranted('ROLE_RESPONSABLE_CLUB')
            or $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
        )
        {
            $evt->setEtat(0);
            $form = $this->createForm(EvenementType::class, $evt);
            $form->handleRequest($request); /*creation d'une session pr stocker les valeurs de l'input*/
            if ($form->isValid()) {
                $evt->setIdUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($evt);
                $em->flush();
                return $this->redirectToRoute('_afficher_events');
            }
            return $this->render('@Evenement/Evenement/ajout.html.twig', array(
                'form' => $form->createView()
            ));
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT'))
        {
            $evt->setEtat(1);
            $evt->setUsrRole("Etudiant") ;


            $form = $this->createForm(Evenement2Type::class, $evt);
            $form->handleRequest($request); /*creation d'une session pr stocker les valeurs de l'input*/
            $coor=new Coordinate(36.8991287,10.1896075);

            $marker = new Marker($coor);
            $marker->setOption('draggable',true);
            $map = new Map();
            $map->getOverlayManager()->addMarker($marker);
            $event=new Event(
                $marker->getVariable(),
                'dragend',
                'function() {alert("Marker dragged!");}',
                true

            );

            $map->getEventManager()->addEvent($event);

            $coor=$marker->getPosition();
           $coor2= $map->getEventManager()->getEventsOnce();
           $marker->
            $map->setMapOption('zoom',15);
            $map->setCenter($coor);
            if ($form->isValid()) {
                $evt->setIdUser($this->getUser());
                $evt->setLatitude($coor->getLatitude());
                $evt->setLongitude($coor->getLongitude());
                $em = $this->getDoctrine()->getManager();
                $em->persist($evt);
                $em->flush();
                return $this->redirectToRoute('_afficher_events');
            }
            return $this->render('@Evenement/Evenement/ajout.html.twig', array(
                'form' => $form->createView(),'map'=>$map
            ));
        }
        if ( $this->get('security.authorization_checker')->isGranted('ROLE_ENSEIGNANT'))
        {
            $evt->setEtat(1);
            $evt->setUsrRole("Enseignant") ;
            $form = $this->createForm(Evenement2Type::class, $evt);
            $form->handleRequest($request); /*creation d'une session pr stocker les valeurs de l'input*/
            if ($form->isValid()) {
                $evt->setIdUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($evt);
                $em->flush();
            }
            return $this->render('@Evenement/Evenement/ajout.html.twig', array(
                'form' => $form->createView()
            ));
        }


        return $this->render('@Evenement/Evenement/ajout.html.twig');

    }

    public function adminAjoutAction(Request $request)
    {
        $evt = new Evenement();
            $evt->setEtat(0);
            $form = $this->createForm(EvenementAdminType::class, $evt);
            $form->handleRequest($request); /*creation d'une session pr stocker les valeurs de l'input*/
            if ($form->isValid()) {
                $evt->setIdUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($evt);
                $em->flush();
                return $this->redirectToRoute("_admin_afficher_events");
            }
            return $this->render('admin/partial/EvenementAdmin/ajouterEvenementAdmin.html.twig', array(
                'form' => $form->createView()
            ));

    }


    public function modifierAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $id=$request->get('id');
            $titre=$request->get('titre');
            $description=$request->get('description');
            $date=$request->get('date');
            $type=$request->get('type');
            $em=$this->getDoctrine()->getManager();
            $evts=$em->getRepository('EvenementBundle:Evenement')->find($id);
            $evts->setTitreE($titre);
            $evts->setDescE($description);
            $evts->setDateE(new \DateTime($date));
            $evts->setTypeE($type);


            $em->persist($evts);
            $em->flush();
            return new Response("Succes!");

        }
        return new Response("Requête invalide",400);
    }

    public function adminModifierImgEventAction(Request $request)
    {
        $id=$_GET['id'];
        $evts=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->find($id);
        $form=$this->createForm(ModiferImgEvtType::class,$evts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($evts);
            $em->flush();
            return $this->redirectToRoute('_admin_afficher_events');
        }
        return $this->render("@Evenement/Evenement/modifierimg.html.twig",array('evt'=>$evts,'form'=>$form->createView()));
    }

    public function ModifierImgEventAction(Request $request)
    {
        $id=$_GET['id'];
        $evts=$this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenement')->find($id);
        $form=$this->createForm(ModiferImgEvtType::class,$evts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($evts);
            $em->flush();
            return $this->redirect('http://localhost/pidemo11/web/app_dev.php/Events_a/afficherunevent?id='.$id);
        }
        return $this->render("@Evenement/Evenement/modifierimg.html.twig",array('form'=>$form->createView()));
    }


    public function adminModifierAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $id=$request->get('id');
           // $image=$request->get('image');
            $titre=$request->get('titre');
            $description=$request->get('description');
            $date=$request->get('date');
            $type=$request->get('type');
            $em=$this->getDoctrine()->getManager();
            $evts=$em->getRepository('EvenementBundle:Evenement')->find($id);
           // $evts->setImage($image);
            $evts->setTitreE($titre);
            $evts->setDescE($description);
            $evts->setDateE(new \DateTime($date));
            $evts->setTypeE($type);


                $em->persist($evts);
                $em->flush();
                return new Response("Succes!");

        }
            return new Response("Requête invalide",400);

    }

    public function supprimerAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();

            $evt = $em->getRepository("EvenementBundle:Evenement")->find($id);
            $em->remove($evt);
            $em->flush();
            return new Response("Succes!");
        }
        return new Response("Requête invalide",400);
    }


    public function adminSupprimerAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();

            $evt = $em->getRepository("EvenementBundle:Evenement")->find($id);
            $em->remove($evt);
            $em->flush();
            return new Response("Succes!");
        }
        return new Response("Requête invalide",400);
    }


    public function afficherAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("EvenementBundle:Evenement")->findAll();
        return $this->render('@Evenement/Evenement/afficher.html.twig', array(
            "evts" => $evt
        ));

    }

    public function afficherUnEventAction()
    {

        $coor=new Coordinate(36.8991287,10.1896075);

        $marker = new Marker($coor);
        $marker->setOption('draggable',true);
        $map = new Map();
        $map->getOverlayManager()->addMarker($marker);

        $map->getEventManager()->addEvent(new Event(
            $marker->getVariable(),
            'dragend',
            'function() {alert("Marker dragged!");}',
            true,
            $coor=$marker->getPosition()
        ));
        $coor=$marker->getPosition();

        $map->setMapOption('zoom',15);
        $map->setCenter($coor);

        $em = $this->getDoctrine()->getManager();
        $id = $_GET['id'];
        $evt = $em->getRepository("EvenementBundle:Evenement")->find($id);
        return $this->render('@Evenement/Evenement/afficherUnEvent.html.twig', array(
            "evt" => $evt,'map'=>$map
        ));

    }


    public function adminAfficherAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("EvenementBundle:Evenement")->findAll();

        return $this->render('admin/partial/EvenementAdmin/afficheEvenementAdmin.html.twig', array(
            "evts" => $evt
        ));

    }



    public function traiterPropositionsEvtAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("EvenementBundle:Evenement")->findBy(array('etat'=>1));

        return $this->render('admin/partial/EvenementAdmin/TraiterPropostitionsEvt.html.twig', array("evts" => $evt
        ));
    }


    public function accepterPropositionsEvtAction()
    {
        $id=$_GET['id'];
        $evt=$this->getDoctrine()->getRepository('EvenementBundle:Evenement')->find($id);
        $evt->setEtat(0);
        $em=$this->getDoctrine()->getManager();
        $em->persist($evt);
        $em->flush();
        return $this->redirectToRoute('admin_traiter_demande_events');
    }

    public function refuserPropositionsEvtAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id=$_GET['id'];
        $evt = $em->getRepository("EvenementBundle:Evenement")->find($id);
        $em->remove($evt);
        $em->flush();
        return $this->redirectToRoute('admin_traiter_demande_events');

    }

    public function participerEventAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id=$_GET['id'];
        $evt = $em->getRepository("EvenementBundle:Evenement")->find($id);

        $participant=$this->getUser();
        $evt->addParticipants($participant);
        $em->persist($evt);
        $em->flush();
        return $this->redirectToRoute('_afficher_events');
    }

    public function afficherTriAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("EvenementBundle:Evenement")->trier();
        return $this->render('@Evenement/Evenement/afficher.html.twig', array(
            "evts" => $evt
        ));
    }

    public function mapAction()
    {
        $coor=new Coordinate(36.8991287,10.1896075);

        $marker = new Marker($coor);
        $marker->setOption('draggable',true);
        $map = new Map();
        $map->getOverlayManager()->addMarker($marker);

        $map->getEventManager()->addEvent(new Event(
            $marker->getVariable(),
            'dragend',
            'function() {alert("Marker dragged!");}',
            true,
            $coor=$marker->getPosition()
        ));
        $coor=$marker->getPosition();

        $map->setMapOption('zoom',15);
        $map->setCenter($coor);
        /*$coor=new Coordinate(36.8983963,10.1875433);

        $map = new Map();
        $map->setCenter($coor);
        $map->setMapOption('zoom',15);
        $marker = new Marker($coor);
        // Configure your marker options
        //$marker->setPrefixJavascriptVariable('marker_');

        $map->getOverlayManager()->addMarker($marker);*/
        //$marker->setAnimat
        // Requests the ivory google map geocoder service
      //  $geocoder = $this->get('ivory.google_map.geocoder');

// Geocode an address
       // $request = new GeocoderAddressRequest('petite ariana, tunis, tunisia');
       // $response = $this->container->get('ivory.google_map.geocoder')->geocode($request);

// Get the result corresponding to your address
        //foreach($response->getResults() as $result) {
          //  var_dump($result->getGeometry()->getLocation());
       // }
        return $this->render('@Evenement/Evenement/map.html.twig',array("map"=>$map));
    }
}
