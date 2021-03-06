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
use Application\Bundle\UserBundle\Entity\User;
use Application\Bundle\CoreBundle\Form\Type\SolutionRatingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Method("GET")
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
     * @Method("POST")
     * @Route("/{id}/save-rating", name="solution_rating_save")
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
     * @Method("GET")
     * @Route("/{username}/solutions", name="user_solutions_list")
     * @ParamConverter("user", class="ApplicationUserBundle:User")
     */
    public function userSolutionsAction(User $user, Request $request)
    {
        $solutionRepository = $this->getDoctrine()->getRepository('ApplicationCoreBundle:Solution');

        $solutions = $solutionRepository->findBy(['user' => $user]);

        return $this->render(
            'ApplicationCoreBundle:User:solutions.html.twig',
            [
                'user'      => $user,
                'solutions' => $solutions
            ]
        );
    }
}
