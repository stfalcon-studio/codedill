<?php

namespace Application\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AddSolutionType
 */
class AddSolutionType extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder Builder
     * @param array $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'ace_editor', array(
                'wrapper_attr' => array(), // aceeditor wrapper html attributes.
                'width' => 1200,
                'height' => 300,
                'font_size' => 14,
                'mode' => 'ace/mode/html', // every single default mode must have ace/mode/* prefix
                'theme' => 'ace/theme/github', // every single default theme must have ace/theme/* prefix
                'tab_size' => null,
                'read_only' => null,
                'use_soft_tabs' => null,
                'use_wrap_mode' => null,
                'show_print_margin' => null,
                'highlight_active_line' => null
            ));
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'add_solution';
    }

    /**
     * Set default options
     *
     * @param OptionsResolverInterface $resolver Resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Application\Bundle\CoreBundle\Entity\Solution',
        ]);
    }
}
