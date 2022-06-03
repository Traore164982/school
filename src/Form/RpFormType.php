<?php

namespace App\Form;

use App\Entity\Rp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet',TextType::class)
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('agreeTerms', CheckboxType::class,["mapped"=>false,"required"=>false])
            ->add('save',SubmitType::class,[
                "label" => "Enregistrer"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rp::class,
            'csrf_protection' => true,
            'csrf-field_name' => 'token',
            'csrf_token_id' => 'et_item'
        ]);
    }
}
