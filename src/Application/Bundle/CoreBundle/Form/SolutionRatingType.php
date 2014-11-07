<?php

namespace Application\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SolutionRatingType
 */
class SolutionRatingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'rating_value',
                'choice',
                [
                    'label'       => 'Rating',
                    'empty_value' => false,
                    'multiple'    => false,
                    'expanded'    => true
                ]
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'solution_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Application\Bundle\CoreBundle\Entity\SolutionRating'
            ]
        );
    }
}
