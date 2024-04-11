<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Room;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Repository\RoomRepository;
class PostType extends AbstractType
{

    private $stringToFileTransformer;
    private $roomRepository;

    // public function __construct(StringToFileTransformer $stringToFileTransformer)
    // {
    //     $this->stringToFileTransformer = $stringToFileTransformer;
    // }

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        ->add('room', ChoiceType::class, [
            'choices' => $options['rooms'],
            'choice_label' => 'sub_category', 
            'placeholder' => 'Choose a room',
            'attr' => ['class' => 'form-select'],
        ])
        // ->add('room', EntityType::class, [
        //     'class' => Room::class,
        //     'choice_label' => 'sub_category', 
        // ])
        ->add('author', TextType::class, [
            'label' => 'author',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('content', TextType::class, [
            'label' => 'content',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('img_url', FileType::class, [
            'label' => 'Upload Image',
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new Assert\File([
                    'maxSize' => '100M',
                    'mimeTypes' => [
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file',
                ])
            ],
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'rooms' => [],
        ]);
    }
}
