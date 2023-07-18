<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use App\Repository\DirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/director', name: 'director_')]
class DirectorController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(DirectorRepository $directorRepository): Response
    {
        
        return $this->render('director/index.html.twig', [
            'directors' => $directorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, DirectorRepository $directorRepository, SluggerInterface $slugger): Response
    {
        $director = new Director();
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($director->getName());
            $director->setSlug($slug);
            $directorRepository->save($director, true);

            return $this->redirectToRoute('director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('director/new.html.twig', [
            'director' => $director,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Director $director): Response
    {
        return $this->render('director/show.html.twig', [
            'director' => $director,
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Director $director, DirectorRepository $directorRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($director->getName());
            $director->setSlug($slug);
            $directorRepository->save($director, true);

            return $this->redirectToRoute('director_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('director/edit.html.twig', [
            'director' => $director,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Director $director, DirectorRepository $directorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$director->getId(), $request->request->get('_token'))) {
            $directorRepository->remove($director, true);
        }

        return $this->redirectToRoute('director_index', [], Response::HTTP_SEE_OTHER);
    }
}
