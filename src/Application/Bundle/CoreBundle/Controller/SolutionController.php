<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        $solutionRatingRepository = $this->getDoctrine()->getManager()->getRepository('ApplicationCoreBundle:SolutionRating');
        $solutionRating = $solutionRatingRepository->findBySolution($solution);

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
     * @ParamConverter("solution", class="ApplicationCoreBundle:Solution")
     */
    public function saveRatingAction(Solution $solution, Request $request)
    {
        $formName    = 'solution_rating';
        $form        = $this->createForm(new SolutionRatingType());
        $requestData = $request->get($formName);

        if ($request->isMethod('POST')) {
            $form->submit($requestData);
        }

        $solutionRating = $form->getData();
        $solutionRating->setSolution($solution);
        $solutionRating->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($solutionRating);
        $em->flush();

        return new JsonResponse([
            'ok' => true
        ]);
    }
}
