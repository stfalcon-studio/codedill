<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Application\Bundle\CoreBundle\Form\Type\AddSolutionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Application\Bundle\UserBundle\Entity\User;

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
     * @return Response
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
    }

    /**
     * Add solution to task
     *
     * @param Task    $task    Task
     * @param Request $request Request
     *
     * @Route("/{id}/add-solution", name="add_solution")
     *
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     *
     * @Method({"GET", "POST"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     *
     */
    public function addSolutionAction(Task $task, Request $request)
    {
        $user = $this->getUser();

        if ($this->checkIfUserSolutionForTaskExists($user, $task)) {
            throw $this->createNotFoundException('Error!Solution must be unique.');
        }

        $solution = new Solution();
        $solution->setTask($task);
        $solution->setUser($user);

        $form = $this->createForm($this->get('app.add_solution_type.form'), $solution);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $solution = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($solution);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                'Your solution has been added!'
            );

            return $this->redirect($this->generateUrl('show_task', ['id' => $task->getId()]));
        } else {
            if ($request->isMethod('POST')) {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Form is invalid'
                );
            }
        }

        return $this->render(
            'ApplicationCoreBundle:Task:add_solution.html.twig',
            [
                'task' => $task,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Show task
     *
     * @param Task $task Task
     *
     * @return Response
     *
     * @Route("/{id}", name="show_task")
     *
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     *
     * @Method({"GET"})
     */
    public function showAction(Task $task)
    {
        /** @var \Application\Bundle\CoreBundle\Repository\SolutionRepository $solutionRepository */
        $solutionRepository = $this->getDoctrine()->getRepository('ApplicationCoreBundle:Solution');

        /** @var array|Solution[] $solutions */
        $solutions = $solutionRepository->findBy(['task' => $task]);

        $ratingsForms = [];
        foreach ($solutions as $solution) {
            $data = new SolutionRating();
            $data->setSolution($solution);

            $ratingsForms[] = $this
                ->get('form.factory')
                ->createNamed(
                    'solution_rating_' . $solution->getId(),
                    new SolutionRatingType(),
                    $data
                )
                ->createView();
        }

        return $this->render(
            'ApplicationCoreBundle:Task:show.html.twig',
            [
                'task'             => $task,
                'ratings_forms'    => $ratingsForms,
                'is_user_solution' => $this->checkIfUserSolutionForTaskExists($this->getUser(), $task)
            ]
        );
    }

    /**
     * List of solutions to task
     *
     * @param Task    $task    The task entity
     * @param Request $request The request object
     *
     * @Route("/{id}/solutions", name="task_solutions_list")
     *
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     *
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     *
     */
    public function listSolutionsAction(Task $task, Request $request)
    {
        $user = $this->getUser();

        $solutionsRepository  = $this->getDoctrine()->getManager()->getRepository('ApplicationCoreBundle:Solution');
        $userSolutionsForTask = $solutionsRepository->findBy(
            [
                'user' => $user,
                'task' => $task
            ]
        );

        if (empty($userSolutionsForTask)) {
            throw new AccessDeniedHttpException('You must first post your solution');
        }

        $taskSolutions = $solutionsRepository->findBy(['task' => $task], ['createdAt' => 'DESC']);

        return $this->render(
            'ApplicationCoreBundle:Solution:list_solutions.html.twig',
            [
                'task' => $task,
                'solutions' => $taskSolutions
            ]
        );
    }

    /**
     * List of solutions ratings to task
     *
     * @param Task $task Task
     *
     * @Route("/{id}/rating", name="list_solutions_ratings")
     *
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     *
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function listSolutionsRatingAction(Task $task)
    {
        $solutionsRatingsRepository = $this->getDoctrine()->getManager()->getRepository('ApplicationCoreBundle:SolutionRating');
        $solutionsRatings = $solutionsRatingsRepository->findSolutionRatingsByTask($task);


        return $this->render(
            'ApplicationCoreBundle:Solution:list_solutions_ratings.html.twig',
            [
                'ratings' => $solutionsRatings
            ]
        );
    }

    /**
     * Check unique solution for user
     *
     * @param User $user
     * @param Task $task
     *
     * @return bool
     */
    public function checkIfUserSolutionForTaskExists($user, $task)
    {
        $solutionRepository = $this->getDoctrine()->getManager()->getRepository('ApplicationCoreBundle:Solution');
        $result = $solutionRepository->findOneBy(['task' => $task, 'user' => $user]);

        return (is_null($result)) ? false : true;
    }
}
