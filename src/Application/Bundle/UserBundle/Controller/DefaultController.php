<?php

namespace Application\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name = 'Головний секретний УКРОП')
    {
        return $this->render('ApplicationUserBundle:Default:index.html.twig', ['name' => $name]);
    }
}
