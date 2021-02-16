<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Specificity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget Maximal'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface Minimale'
                ]
            ])
            ->add('specificities', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Specificity::class,
                'choice_label' => 'name',
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            // Research must be done with get method
            'method' => 'get',
            // We don't need a token for a research
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        // Ne retien retourner comme prefix dans l'url
        // Avant https://localhost:8000/biens?property_search%5BminSurface%5D=&property_search%5BmaxPrice%5D=15
        // Après https://localhost:8000/biens?minSurface=11&maxPrice=16
        return '';
    }
}
