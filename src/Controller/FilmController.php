<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/film', name: 'film_')]
class FilmController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, FilmRepository $filmRepository): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $filmRepository->save($film, true);
            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', methods: ['GET'], name: 'show')]
    public function show(int $id, FilmRepository $filmRepository): Response
    {
        $film = $filmRepository->findOneBy(['id' => $id]);
        if (!$film) {
            throw $this->createNotFoundException(
                'No film with id : ' . $id . ' found in film\'s table.'
            );
        }

        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, FilmRepository $filmRepository): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filmRepository->save($film, true);

            return $this->redirectToRoute('film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, FilmRepository $filmRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $film->getId(), $request->request->get('_token'))) {
            $filmRepository->remove($film, true);
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}
