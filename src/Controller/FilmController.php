<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Form\SearchFilmType;
use App\Repository\FilmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/film', name: 'film_')]
class FilmController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, FilmRepository $filmRepository, PaginatorInterface $paginatorInterface): Response
    {


        $form = $this->createForm(SearchFilmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $films = $filmRepository->findFilm($data['search']);
        } else {
            $films = $filmRepository->findAll();
        }

        $pagination = $paginatorInterface->paginate(
            $filmRepository->paginationQuery(),
            $request->query->get('page', 1),
            12
        );

        return $this->render('film/index.html.twig', [
            'pagination' => $pagination,
            'films' => $films,
            'form' => $form
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, FilmRepository $filmRepository, SluggerInterface $slugger): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($film->getTitle());
            $film->setSlug($slug);
            $filmRepository->save($film, true);
            $this->addFlash('success', 'Le nouveau film a bien été créée.');
            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', methods: ['GET'], name: 'show')]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, FilmRepository $filmRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($film->getTitle());
            $film->setSlug($slug);
            $filmRepository->save($film, true);
            $this->addFlash('success', 'Le film a bien été modifiée.');

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
            $this->addFlash('success', 'Le film a bien été supprimée.');
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}