<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\CoreBundle\Entity\SolutionRating;
use Application\Bundle\CoreBundle\Form\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SolutionRatingController
 *
 * @Route("/solutions")
 */
class SolutionRatingController extends Controller
{
    /**
     * @param Solution $solution
     * @param Request  $request
     *
     * @return Response
     *
     * @Route("/{id}/ratings/save", name="solution_rating_save")
     * @ParamConverter("solution", class="ApplicationCoreBundle:Solution")
     */
    public function saveAction(Solution $solution, Request $request)
    {
        $formName    = 'solution_rating_' . $solution->getId();
        $form        = $this->createForm(new SolutionRatingType());
        $requestData = $request->get($formName);

        $data = new SolutionRating();

        if ($request->isMethod('post')) {
            $form->submit($requestData);
        }

        $data = $form->getData();
        $data->setSolution($solution);
        $data->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new JsonResponse([
            'ok' => true
        ]);
    }
}
