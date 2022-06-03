<?php

namespace App\Form;

use App\Entity\Attache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AttacheFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet')
            ->add('email')
            ->add('password')
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false,'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attache::class,
            'csrf_protection' => true,
            'csrf-field_name' => 'token',
            'csrf_token_id' => 'et_item'
        ]);
    }
}