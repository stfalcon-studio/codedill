<?php

namespace Application\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApplicationCoreBundle:Task:index.html.twig');
    }
}
