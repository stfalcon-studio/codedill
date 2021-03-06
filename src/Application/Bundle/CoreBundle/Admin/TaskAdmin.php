<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Task Entity Admin
 */
class TaskAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'task';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_task';

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('createdAt');

        return $listMapper;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description', 'ace_editor', [
                'wrapper_attr'          => [], // aceeditor wrapper html attributes.
                'width'                 => 800,
                'height'                => 300,
                'font_size'             => 14,
                'mode'                  => 'ace/mode/html', // every single default mode must have ace/mode/* prefix
                'theme'                 => 'ace/theme/github',
                // every single default theme must have ace/theme/* prefix
                'tab_size'              => null,
                'read_only'             => null,
                'use_soft_tabs'         => true,
                'use_wrap_mode'         => null,
                'show_print_margin'     => null,
                'highlight_active_line' => true
            ]);

        return $formMapper;
    }
}
