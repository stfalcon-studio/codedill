<?php

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
        return array(
            new \Twig_SimpleFilter('ace_editor_read_only', array($this, 'renderEditor')),
        );
    }

    /**
     * @param  string $code
     * @return string
     */
    public function renderEditor($code)
    {
        $this->params['read_only'] = false;
        $this->params['code'] = $code;

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
