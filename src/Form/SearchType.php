<?php

namespace App\Form;

use App\DTO\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control w-50 m-2',
                    'placeholder' => 'Rechercher par titre']
            ])
            ->add("envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary m-2'
                ],
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            "dataClass" => SearchData::class,
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }
}
