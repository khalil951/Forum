<?php

namespace App\Form;

use App\Entity\PostReact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostReactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post_id')
            ->add('user_id')
            ->add('Isliked')
            ->add('post')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostReact::class,
        ]);
    }
}
