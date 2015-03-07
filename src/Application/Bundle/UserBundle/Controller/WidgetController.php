<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * WidgetController
 */
class WidgetController extends Controller
{
    /**
     * Widget user toolbar
     */
    public function userToolbarAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $user = $this->getUser();

            return $this->render(
                '@ApplicationUser/Widget/user-toolbar/_authorized.html.twig',
                [
                    'user' => $user
                ]
            );

        } else {
            return $this->render('@ApplicationUser/Widget/user-toolbar/_anonymous.html.twig');
        }
    }
}
