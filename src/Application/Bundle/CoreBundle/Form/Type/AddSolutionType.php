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
     * @param array                $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'textarea')
            ->add('save', 'submit');
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
