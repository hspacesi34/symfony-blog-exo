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
                ],
                'row_attr' => [
                    'class' => 'form-control mb-4',
                ],
                'label_attr' => [
                    'class' => 'label',
                ],
            ])
            ->add('firstname_user', null, [
                'attr' => [
                    'class' => 'input input-bordered w-full max-w-xs',
                ],
                'row_attr' => [
                    'class' => 'form-control mb-4',
                ],
                'label_attr' => [
                    'class' => 'label',
                ],
            ])
            ->add('email_user', EmailType::class, [
                'row_attr' => ['class' => 'form-control w-full max-w-xs'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input input-bordered w-full max-w-xs'],
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
                ],
                'constraints' => [
                    new IsTrue(message: 'You should agree to our terms.'),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'form-control w-full max-w-xs'],
                'label_attr' => ['class' => 'label'],
                'attr' => ['class' => 'input input-bordered w-full max-w-xs', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(message: 'Please enter a password'),
                    new Length(min: 6, minMessage: 'Your password should be at least {{ limit }} characters', max: 4096),
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
