<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actor;
use App\Repository\ActorRepository;


#[Route('/actor')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'actor_index')]
    public function index(ActorRepository $actorRepository): Response
    {

        return $this->render('actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),

        ]);
    }

    #[Route('/{id}', name: 'app_actor_show', methods: ['GET'])]
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
