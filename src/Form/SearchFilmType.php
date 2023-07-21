<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchFilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('search', SearchType::class, [
                'label' => 'rechercher',
                'required' => false,
                'trim' => false,
            ])
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Catégorie',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
