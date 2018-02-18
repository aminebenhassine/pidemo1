<?php

namespace EspritEntreAide\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction()
    {

        return $this->render(':default:index.html.twig');
    }

    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig');

    }
}
