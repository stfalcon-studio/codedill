<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AceEditorReadOnlyExtension
 */
class AceEditorReadOnlyExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $params;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('ace_editor_read_only', [$this, 'renderEditor']),
        ];
    }

    /**
     * @param  string $code
     * @param  string $style
     *
     * @return string
     */
    public function renderEditor($code, $style)
    {
        $this->params['read_only'] = true;
        $this->params['code']      = $code;
        $this->params['style']     = $style;

        return $this->container->get('templating')->render(
            'ApplicationCoreBundle:AceEditor:ace_editor.html.twig',
            $this->params
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ace_editor_read_only';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}
