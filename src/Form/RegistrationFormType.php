<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LastName', TextType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Nom'
            ])
            ->add('FirstName',TextType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Prénom'
            ])
            ->add('Telephone',TelType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Téléphone'
            ])
            ->add('Address',TextType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Adresse'
            ])
            ->add('Birthdate',BirthdayType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Date de naissance'
            ])

            ->add('ZipCode',IntegerType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Code Postal'
            ])
            ->add('City',TextType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Ville'
            ])
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'E-mail'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'Accepter les conditions',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ 6 }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                    'label' => 'Mot de passe',
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
