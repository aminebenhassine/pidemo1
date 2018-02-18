<?php

namespace EspritEntreAide\EvenementBundle\Controller;

use EspritEntreAide\EvenementBundle\Entity\Evenement;
use EspritEntreAide\EvenementBundle\Form\Evenement2Type;
use EspritEntreAide\EvenementBundle\Form\EvenementType;
use EspritEntreAide\EvenementBundle\Form\ModiferEvtType;
use EspritEntreAide\EvenementBundle\Form\RechercheClubType;
use EspritEntreAide\EvenementBundle\Form\RechercheDateType;
use EspritEntreAide\EvenementBundle\Form\RechercheNomType;
use EspritEntreAide\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $evt = $em->getRepository("EvenementBundle:Evenement")->findBy(array('etat'=>0));
        return $this->render('EvenementBundle:Default:index.html.twig', array(
            "evts" => $evt));
    }

}
