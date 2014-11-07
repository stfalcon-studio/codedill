<?php

namespace Application\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * TaskController
 *
 * @Route("/")
 */
class TaskController extends Controller
{
    /**
     * Index page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $tasks = $this->getDoctrine()->getRepository('ApplicationCoreBundle:Task')->findAll();

        return $this->render(
            'ApplicationCoreBundle:Task:index.html.twig',
            [
                'tasks' => $tasks
            ]
        );

        return $this->render('ApplicationCoreBundle:Task:index.html.twig');
    }

    /**
     * Add solution to task
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/add-solution", name="add_solution")
     * @Method({"GET"})
     */
    public function addSolutionAction()
    {
        return $this->render('ApplicationCoreBundle:Task:add_solution.html.twig');
    }
}
