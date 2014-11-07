<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
     * @param Task $task Task
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/add-solution", name="add_solution")
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     * @Method({"GET"})
     */
    public function addSolutionAction(Task $task)
    {
        return $this->render(
            'ApplicationCoreBundle:Task:add_solution.html.twig',
            [
                'task' => $task
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

    /**
     * List of solutions to task
     *
     * @param Task $task Task
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/solutions", name="list_solution")
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     * @Method({"GET"})
     */
    public function listSolutionsAction(Task $task)
    {
        $user = $this->getUser();
        $solutionsRepository = $this->getDoctrine()->getManager()->getRepository('ApplicationCoreBundle:Solution');
        $userSolutionsForTask = $solutionsRepository->findBy(['user' => $user, 'task' => $task]);
        if (empty($userSolutionsForTask)) {
            throw new AccessDeniedHttpException('You must first post your solution');
        }

        $taskSolutions = $solutionsRepository->findBy(['task' => $task], ['createdAt' => 'DESC']);

        return $this->render(
            'ApplicationCoreBundle:Task:list_solutions.html.twig',
            [
                'solutions' => $taskSolutions
            ]
        );
    }
}