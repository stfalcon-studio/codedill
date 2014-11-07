<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Entity\Task;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * Show task
     *
     * @param Task    $task Task
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/show", name="show_task")
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
