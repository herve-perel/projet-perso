<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActorRepository $actorRepository, SluggerInterface $slugger): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($actor->getName());
            $actor->setSlug($slug);
            $actorRepository->save($actor, true);
            $this->addFlash('success', 'Le nouvel acteur film a bien été créée.');


            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actor/new.html.twig', [
            'slug' => $actor,
            'form' => $form,

        ]);
    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(string $slug, Actor $actor, ActorRepository $actorRepository): Response
    {
        $actor = $actorRepository->findOneBy(['slug' => $slug]);
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actor $actor, ActorRepository $actorRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($actor->getName());
            $actor->setSlug($slug);
            $actorRepository->save($actor, true);
            $this->addFlash('success', 'L\'acteur a bien été modifiée.');


            return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Actor $actor, ActorRepository $actorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $actor->getId(), $request->request->get('_token'))) {
            $actorRepository->remove($actor, true);
            $this->addFlash('success', 'L\'acteur a bien été supprimée.');
        }

        return $this->redirectToRoute('actor_index', [], Response::HTTP_SEE_OTHER);
    }
}