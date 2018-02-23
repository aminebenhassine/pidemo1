<?php

namespace EspritEntreAide\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StoreBundle:Default:index.html.twig');
    }
}
