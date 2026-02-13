<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeImmutableType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title_article', TextType::class, [
                'required' => false,
                'label' => 'Titre de l’article',
                'label_attr' => ['class' => 'block text-lg font-medium mb-2'],
                'attr' => [
                    'placeholder' => 'Entrez le titre de l’article',
                    'class' => 'input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary',
                ],
            ])
            ->add('content_article', TextareaType::class, [
                'required' => false,
                'label' => 'Contenu',
                'label_attr' => ['class' => 'block text-lg font-medium mb-2'],
                'attr' => [
                    'placeholder' => 'Rédigez le contenu de votre article...',
                    'rows' => 8,
                    'class' => 'textarea textarea-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary',
                ],
            ])
            ->add('image_article', FileType::class, [
                'required' => false,
                'label' => "Image de l'article",
                'label_attr' => ['class' => 'block text-lg font-medium mb-2']
            ])
            ->add('categories', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'name_cat',
                'label' => 'Catégories',
                'label_attr' => ['class' => 'block text-lg font-medium mb-2'],
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'select select-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
