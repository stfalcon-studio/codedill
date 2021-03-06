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

use Application\Bundle\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * @Method({"GET"})
     * @Route("/{username}/solutions", name="user_solutions_list")
     * @ParamConverter("user", class="ApplicationUserBundle:User")
     */
    public function userSolutionsAction(User $user)
    {
        // Check if user from URL is same as current user
        if ($user->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $solutionRepository = $em->getRepository('ApplicationCoreBundle:Solution');
        $threadRepository   = $em->getRepository('ApplicationCoreBundle:Thread');

        /** @var \Application\Bundle\CoreBundle\Entity\Solution[] $solutions */
        $solutions = $solutionRepository->findBy(['user' => $user]);

        $threadIds = [];
        foreach ($solutions as $solution) {
            $threadIds[] = 's_' . $solution->getId();
        }

        $solutionCommentsNum = $threadRepository->getThreadsCommentsStats($threadIds);

        return $this->render(
            'ApplicationCoreBundle:User:solutions.html.twig',
            [
                'user'                    => $user,
                'solutions'               => $solutions,
                'solution_comments_stats' => $solutionCommentsNum
            ]
        );
    }

    /**
     * User solution action
     *
     * @param $user
     * @param $solution
     *
     * @internal param int $solution_id
     *
     * @return Response
     *
     * @Method({"GET"})
     * @Route("/{username}/solutions/{id}/feedback", name="user_solution_feedback")
     * @ParamConverter("user", class="ApplicationUserBundle:User", options = {"mapping": {"username": "username"}})
     * @ParamConverter("solution", class="ApplicationCoreBundle:Solution")
     */
    public function userSolutionFeedbackAction($user, $solution)
    {
        return $this->forward(
            'ApplicationCoreBundle:Solution:show',
            [
                'solution' => $solution,
                'request'  => $this->getRequest(),
            ]
        );
    }
}

