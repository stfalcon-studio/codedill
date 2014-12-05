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
                    'choices'  => range(0, 5),
                    'label'    => 'Rating',
                    'multiple' => false,
                    'expanded' => true,
                    'attr'     => [
                        'class' => 'solution-rating-value'
                    ]
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
                'data_class'      => 'Application\Bundle\CoreBundle\Entity\SolutionRating',
                'csrf_protection' => false
            ]
        );
    }
}
