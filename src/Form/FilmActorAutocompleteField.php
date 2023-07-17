<?php

namespace App\Form;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class FilmActorAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Actor::class,
            'label' => 'Acteur',
            'placeholder' => 'Choississez un acteur',
            'choice_label' => 'name',
            'multiple' => true,
            // 'by_reference' => false,
            'query_builder' => function (ActorRepository $actorRepository) {
                return $actorRepository->createQueryBuilder('actor');
            },
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
