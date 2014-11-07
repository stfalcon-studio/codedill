<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * TaskController
 *
 * @Route("/tasks")
 */
class TaskController extends Controller
{
    /**
     * Index page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="tasks_list")
     * @Method({"GET"})
     */
    public function listAction()
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
     * Show task
     *
     * @param Task $task Task
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/show", name="show_task")
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     * @Method({"GET"})
     */
    public function showAction(Task $task)
    {
        $solutions = $this->getDoctrine()->getRepository('ApplicationCoreBundle:Solution')->findByTask($task);

        return $this->render(
            'ApplicationCoreBundle:Task:show.html.twig',
            [
                'task'      => $task,
                'solutions' => $solutions
            ]
        );
    }
}