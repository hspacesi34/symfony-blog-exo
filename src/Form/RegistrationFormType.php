<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_user', null, [
                'attr' => [
                    'class' => 'input input-bordered w-full max-w-xs',
                    'data-cy' => 'name_user'
                ],
                'row_attr' => [
                    'class' => 'form-control mb-4',
                ],
                'label_attr' => [
                    'class' => 'label',
                ],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer un nom"),
                    new Length(min: 2, minMessage: 'Le nom doit contenir {{ limit }} caractères', max: 50),
                ],
            ])
            ->add('firstname_user', null, [
                'attr' => [
                    'class' => 'input input-bordered w-full max-w-xs',
                    'data-cy' => 'firstname_user'
                ],
                'row_attr' => [
                    'class' => 'form-control mb-4',
                ],
                'label_attr' => [
                    'class' => 'label',
                ],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer un prénom"),
                    new Length(min: 2, minMessage: 'Le prénom doit contenir {{ limit }} caractères', max: 50),
                ],
            ])
            ->add('email_user', EmailType::class, [
                'row_attr' => ['class' => 'form-control w-full max-w-xs'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input input-bordered w-full max-w-xs', 'data-cy' => 'email_user'],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer un email"),
                    new Length(min: 2, minMessage: "L'email doit contenir {{ limit }} caractères", max: 180),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => [
                    'class' => 'form-control mb-4',
                ],
                'label_attr' => [
                    'class' => 'label cursor-pointer flex items-center gap-2',
                ],
                'attr' => [
                    'class' => 'checkbox checkbox-primary',
                    'data-cy' => 'agreeTerms'
                ],
                'constraints' => [
                    new IsTrue(message: 'You should agree to our terms.'),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'form-control w-full max-w-xs'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input input-bordered w-full max-w-xs', 'autocomplete' => 'new-password', 'data-cy' => 'plainPassword'],
                'constraints' => [
                    new NotBlank(message: "Merci d'entrer un mot de passe"),
                    new Length(min: 6, minMessage: 'Le mot de passe doit contenir {{ limit }} caractères', max: 100),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
