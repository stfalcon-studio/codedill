<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Application\Bundle\CoreBundle\Form\Type\AddSolutionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

            $this->get('session')->getFlashBag()->add(
                'info',
                'Your solution has been added!'
            );

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
     * @param Task    $task Task
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="show_task")
     * @ParamConverter("task", class="ApplicationCoreBundle:Task")
     * @Method({"GET"})
     */
    public function showAction(Task $task, Request $request)
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
                'task'          => $task,
                'ratings_forms' => $ratingsForms
            ]
        );
    }
}
