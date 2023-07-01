<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    #[Route('/', name: 'index')]
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('/index.html.twig', [
            'films' => $filmRepository->findBy([], ['id' => 'DESC'], 4, 0)
        ]);
    }
}
