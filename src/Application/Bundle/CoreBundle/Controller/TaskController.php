<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\UserBundle\Entity\User;
use Application\Bundle\CoreBundle\Form\Type\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
            throw $this->createNotFoundException('Error! Solution must be unique.');
        }

        $solution = (new Solution())->setTask($task);

        $form = $this->createForm($this->get('app.add_solution_type.form'), $solution);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var \Application\Bundle\CoreBundle\Entity\Solution $solution */
            $solution = $form->getData();

            $solutionService = $this->get('app.solution');
            $solution->setBonus($solutionService->getBonusForSolution($task));

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

        $solution = $solutionRepository->getSolutionByUserAndTask($task, $this->getUser());

        return $this->render(
            'ApplicationCoreBundle:Task:show.html.twig',
            [
                'task'             => $task,
                'ratings_forms'    => $ratingsForms,
                'is_user_solution' => (is_null($solution)) ? false : true,
                'solution'         => $solution
            ]
        );
    }

    /**
     * List of solutions to task
     *
     * @param Task    $task    The task entity
     * @param Request $request The request object
     *
     * @return Response
     *
     * @throws AccessDeniedException
     *
     * @Route("/{id}/solutions", name="task_solutions_list")
     *
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     *
     * @Method({"GET"})
     *
     * @Security("has_role('ROLE_USER')")
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
            throw new AccessDeniedException('You must first post your solution');
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
    public function checkIfUserSolutionForTaskExistsAction($user, $task)
    {
        $solutionRepository = $this->getDoctrine()->getRepository('ApplicationCoreBundle:Solution');
        $result = $solutionRepository->getSolutionByUserAndTask($task, $user);

        return (null === $result) ? false : true;
    }
}
