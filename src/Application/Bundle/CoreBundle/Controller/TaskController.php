<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Form\Type\AddSolutionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

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
     * Add solution to task
     *
     * @param Task    $task    Task
     * @param Request $request Request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/add-solution", name="add_solution")
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     * @Method({"GET", "POST"})
     */
    public function addSolutionAction(Task $task, Request $request)
    {
        $solution = new Solution();
        $solution->setTask($task);

        $form = $this->createForm(new AddSolutionType(), $solution);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $solution = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($solution);
            $em->flush();

            return $this->redirect($this->generateUrl('show_task', ['id' => $task->getId()]));
        }

        return $this->render(
            'ApplicationCoreBundle:Task:add_solution.html.twig',
            [
                'task'  => $task,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Show task
     *
     * @param Task $task Task
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="show_task")
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
