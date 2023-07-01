<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Actor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('category', TextType::class, [
                'label' => 'Categorie'
            ])
            ->add('year', NumberType::class, [
                'label' => 'Année de sortie'
            ])
            ->add('synopsis', TextType::class)
            ->add('support', null,  [
                'choice_label' => 'format',
                'label' => 'Format'
            ])
            ->add('actors', FilmActorAutocompleteField::class)
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true,
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
