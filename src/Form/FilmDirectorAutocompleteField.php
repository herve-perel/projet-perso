<?php

namespace App\Form;

use App\Entity\Director;
use App\Repository\DirectorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class FilmDirectorAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Director::class,
            'label' => 'Réalisateur',
            'placeholder' => 'Choississez un réalisateur',
            'choice_label' => 'name',
            'query_builder' => function (DirectorRepository $directorRepository) {
                return $directorRepository->createQueryBuilder('director');
            },
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
