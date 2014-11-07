<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * SolutionRatingController
 *
 * @Route("/solutions")
 */
class SolutionRatingController extends Controller
{
    /**
     * @return Response
     *
     * @Route("{id}/ratings/save", name="solution_rating_save")
     * @ParamConverter("task", class="ApplicationCoreBundle:Solution")
     */
    public function saveAction(Solution $solution)
    {
        return new JsonResponse([]);
    }
}
