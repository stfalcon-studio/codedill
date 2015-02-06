<?php

namespace Application\Bundle\CoreBundle\Form\Type;

use Application\Bundle\CoreBundle\Entity\Solution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AddSolutionType
 */
class AddSolutionType extends AbstractType
{
    /**
     * @var array
     */
    private $params = array();

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $defaultParams = array(
            'wrapper_attr' => array(), // aceeditor wrapper html attributes.
            'width' => 1200,
            'height' => 400,
            'tab_size' => null,
            'read_only' => null,
            'use_soft_tabs' => true,
            'use_wrap_mode' => null,
            'show_print_margin' => true,
            'highlight_active_line' => true,
        );

        $defaultParams = array_merge($this->params, $defaultParams);

        $builder
            ->add(
                'codeMode',
                'choice',
                array(
                    'choices' => Solution::getCodeModes(),
                )
            )
            ->add('code', 'ace_editor', $defaultParams);
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
