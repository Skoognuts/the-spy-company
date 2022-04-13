<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MissionRepository $missionRepository): Response
    {
        $missions = $missionRepository->getMissions();
        $missionsLength = count($missions);
        if ($missionsLength > 10) {
            $missions = array_slice($missions, 0, 10);
        }
        $pageCount = substr($missionsLength, 0, -1);
        $pageCount = (int)$pageCount + 1;
        return $this->render('default/index.html.twig', [
            'missions' => $missions,
            'missionsLength' => $missionsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'missions')]
    public function missionsList(MissionRepository $missionRepository, int $page): Response
    {
        $missions = $missionRepository->getMissions();
        $missionsLength = count($missions);
        $pageCount = substr($missionsLength, 0, -1);
        $pageCount = (int)$pageCount + 1;
        if ($page == 1 || $missionsLength <= 10) {
            return $this->redirectToRoute('homepage');
        }
        if (($page * 10) >= ($missionsLength + 10)) {
            return $this->redirectToRoute('missions', ['page' => $pageCount]);
        }
        $missions = array_slice($missions, ($page - 1) * 10, 10);
        $newMissionsLength = count($missions);

        return $this->render('default/index_page.html.twig', [
            'missions' => $missions,
            'missionsLength' => $newMissionsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/mission-{id}', name: 'missionId')]
    public function missionId(MissionRepository $missionRepository, int $id): Response
    {
        $mission = $missionRepository->getMissionById($id);
        return $this->render('default/mission.html.twig', [
            'mission' => $mission
        ]);
    }
}
