<?php

namespace Application\Bundle\CoreBundle\Controller;

use Application\Bundle\CoreBundle\Entity\Solution;
use Application\Bundle\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * UserController
 *
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * User solutions action
     *
     * @param User $user User
     *
     * @return Response
     *
     * @Route("/{username}/solutions", name="user_solutions_list")
     * @ParamConverter("user", class="ApplicationUserBundle:User")
     */
    public function userSolutionsActions(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $solutionRepository = $em->getRepository('ApplicationCoreBundle:Solution');
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
