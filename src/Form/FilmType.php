<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('category', FilmCategoryAutocompleteField::class)
            ->add('year', NumberType::class, [
                'label' => 'Année de sortie'
            ])
            ->add('synopsis', TextType::class)
            ->add('support', null,  [
                'choice_label' => 'format',
                'label' => 'Format',
                'placeholder' => 'Choississez un format'

            ])
            ->add('actors', FilmActorAutocompleteField::class)
            ->add('director', FilmDirectorAutocompleteField::class)
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'download_uri' => true,
                'label' => 'Ajouter une image'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,

        ]);
    }
}
