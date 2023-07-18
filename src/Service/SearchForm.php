<?php

namespace App\Service;

use App\Form\SearchFilmType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchForm extends AbstractController

{
    public function searchNavBar(Request $request, FilmRepository $filmRepository): string
    {
        $form = $this->createForm(SearchFilmType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $films = $filmRepository->findFilm($data['search']);
        } else {
            $films = $filmRepository->findAll();
        }

        return $this->render('index.html.twig', [
            'films' => $films,
            'form' => $form
        ]);
    }
}
