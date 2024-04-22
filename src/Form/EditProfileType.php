<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles')
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
           
            ->add('Address',TextType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Adresse'
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

            ->add('Telephone',TelType::class,[
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Téléphone'
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
