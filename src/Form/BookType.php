<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('isbn', TextType::class, [
                'label' => 'Code ISBN du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('stock', NumberType::class, [
                'label' => 'Nombre de livre en stock',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('year', NumberType::class, [
                'label' => 'Date de sortie du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => 'catégorie du livre',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'image du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
