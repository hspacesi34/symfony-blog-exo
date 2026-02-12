<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_cat', TextType::class, [
                'label' => 'Nom de la catégorie',
                'label_attr' => [
                    'class' => 'block text-lg font-medium mb-2',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex. : Musique, Livres, Jeux vidéo',
                    'class' => 'input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary',
                    'data-cy' => 'name_cat'
                ],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer un nom"),
                    new Length(min: 2, minMessage: 'Le nom doit contenir {{ limit }} caractères', max: 50),
                ],
            ])
            ->add('description_cat', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'block text-lg font-medium mb-2',
                ],
                'attr' => [
                    'placeholder' => 'Décris brièvement cette catégorie...',
                    'rows' => 5,
                    'class' => 'textarea textarea-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary',
                    'data-cy' => 'description_cat'
                ],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer une description"),
                    new Length(min: 2, minMessage: 'La description doit contenir {{ limit }} caractères'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
