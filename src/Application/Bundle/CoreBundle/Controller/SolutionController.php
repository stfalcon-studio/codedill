<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * SolutionController
 *
 * @Route("/solutions")
 */
class SolutionController extends Controller
{
    /**
     * Show action
     *
     * @param Solution $solution Solution
     * @param Request  $request  Request
     *
     * @return Response
     *
     * @Route("/{id}/show", name="solution_show")
     * @ParamConverter("solution", class="ApplicationCoreBundle:Solution")
     */
    public function showAction(Solution $solution, Request $request)
    {
        $solutionRatingRepository = $this->getDoctrine()
                                         ->getRepository('ApplicationCoreBundle:SolutionRating');
        $solutionRating = $solutionRatingRepository->findOneBySolution($solution);

        if (!($solutionRating instanceof SolutionRating)) {
            $solutionRating = new SolutionRating();
            $solutionRating->setSolution($solution);
        }

        $ratingForm = $this->createForm(new SolutionRatingType(), $solutionRating);

        return $this->render(
            'ApplicationCoreBundle:Solution:show.html.twig',
            [
                'solution'    => $solution,
                'rating_form' => $ratingForm->createView()
            ]
        );
    }

    /**
     * @param Solution $solution
     * @param Request  $request
     *
     * @return Response
     *
     * @Route("/{id}/save-rating", name="solution_rating_save")
     * @Method("POST")
     * @ParamConverter("solution", class="ApplicationCoreBundle:Solution")
     */
    public function saveRatingAction(Solution $solution, Request $request)
    {
        $form = $this->createForm(new SolutionRatingType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $solutionRatingRepository = $this->getDoctrine()->getRepository('ApplicationCoreBundle:SolutionRating');
            /** @var \Application\Bundle\CoreBundle\Entity\SolutionRating $solutionRating */
            $solutionRating           = $solutionRatingRepository->findOneBy([
                'solution' => $solution,
                'user'     => $this->getUser()
            ]);

            if (!$solutionRating) {
                $solutionRating = (new SolutionRating())->setSolution($solution)
                                                        ->setUser($this->getUser());
            }

            $solutionRating->setRatingValue($form->getData()->getRatingValue());

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($solutionRating);
                $em->flush();
            } catch (\Exception $e) {
                return new JsonResponse([
                    'ok'    => false,
                    'error' => $e->getMessage()
                ]);
            }

            return new JsonResponse([
                'ok' => true
            ]);
        }

        return new JsonResponse([
            'ok'    => false,
            'error' => $form->getErrors()
        ]);
    }

    /**
     * Solutions action
     *
     * @param User    $user    User
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/{username}/solutions", name="user_solutions_list")
     * @ParamConverter("user", class="ApplicationUserBundle:User")
     */
    public function userSolutionsActions(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $solutionRepository = $em->getRepository('ApplicationCoreBundle:Solution');
        $solutions = $solutionRepository->findBy(['user' => $user]);

        return $this->render(
            'ApplicationUserBundle:User:solutions.html.twig',
            [
                'user'      => $user,
                'solutions' => $solutions
            ]
        );
    }
}
