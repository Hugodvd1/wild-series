<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RequestStack $requestStack, ProgramRepository $programRepository): Response
    {
        $session = $requestStack->getSession();
        if (!$session->has('total')) {
            $session->set('total', 0); // if total doesn’t exist in session, it is initialized.
        }

        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            $programRepository->save($program, true);
            $this->addFlash('success', 'The new program has been created');

            // And redirect to a route that display the result
            return $this->redirectToRoute('program_index');
        }
        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(int $id, Program $program): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }




    #[Route('/{program<\d+>}/season/{season<\d+>}', name: 'season_show', methods: ['GET'])]
    // #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]
    // #[Entity('season', options: ['mapping' => ['season_id' => 'id']])]
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

    #[Route('/{program<\d+>}/season/{season<\d+>}/episodes/{episode<\d+>}', name: 'episode_show', methods: ['GET'])]
    // #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]
    // #[Entity('season', options: ['mapping' => ['season_id' => 'id']])]
    // #[Entity('episode', options: ['mapping' => ['episode_id' => 'id']])]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}
