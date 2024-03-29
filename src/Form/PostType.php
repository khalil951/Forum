<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Room;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('room', ChoiceType::class, [
            'choices' => $options['rooms'],
            'choice_label' => 'sub_category', 
            'placeholder' => 'Choose a room',
            'attr' => ['class' => 'form-select'],
        ])
        ->add('author', TextType::class, [
            'label' => 'author',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('content', TextType::class, [
            'label' => 'content',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('img_url', TextType::class, [
            'label' => 'img_url',
            'attr' => ['class' => 'form-control'],
        ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'rooms' => [],
        ]);
    }
}
