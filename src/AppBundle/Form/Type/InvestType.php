<?php

namespace AppBundle\Form\Type;

/**
 * Invest form
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Form\Type
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class InvestType extends AbstractType
{
    /**
     * @var float
     */
    protected $available_for_investment;

    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('invest', NumberType::class, [
            'constraints' => [
                new NotBlank(),
                new Type('float'),
                new LessThanOrEqual($options['available_for_investment'])
            ],
            'scale' => 2,
            'attr' => [
                'class' => 'form-control'
            ]
        ])->add('save', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-default'
            ]
        ]);
    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'available_for_investment' => 0
        ]);
    }
}