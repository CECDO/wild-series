<?php
//src/Controller/programController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;

/**
* @Route("/program", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     * 
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

     /**
 * Getting a program by id
 *
 * @Route("/{program_id}", name="show")
 * @return Response
 */
    public function show(int $program_id):Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $program_id]);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$program_id.' found in program\'s table.'
        );
    }
    return $this->render('program/show.html.twig', [
        'program' => $program,
    ]);
    }

    /**
     * Undocumented function
     *@Route("/{program_id}/seasons/{season_id}", name= "season_show")
     */
    public function showSeason(int $program_id, int $season_id, ProgramRepository $programRepository, SeasonRepository $seasonRepository)
    {
        $program = $programRepository->find($program_id);
        $season = $seasonRepository->find($season_id);
        if ($program === null || $season === null) {
            throw $this->createNotFoundException(
                "Ce programme ou cette saison n'existe pas."
            );
        }
        return $this->render("program/season_show.html.twig", [
            'season' => $season,
            'program' => $program,
        ]);
    }
}
