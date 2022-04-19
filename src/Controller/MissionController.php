<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/missions')]
class MissionController extends AbstractController
{
    #[Route('/', name: 'app_mission_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): Response
    {
        $missions = $missionRepository->getMissions();
        $missionsLength = count($missions);
        if ($missionsLength > 10) {
            $missions = array_slice($missions, 0, 10);
        }
        $pageCount = substr($missionsLength, 0, -1);
        if (substr($missionsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
            'missionsLength' => $missionsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'app_mission_index_page')]
    public function missionsList(MissionRepository $missionRepository, int $page): Response
    {
        $missions = $missionRepository->getMissions();
        $missionsLength = count($missions);
        $pageCount = substr($missionsLength, 0, -1);
        if (substr($missionsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        if ($page == 1 || $missionsLength <= 10) {
            return $this->redirectToRoute('app_mission_index');
        }
        if (($page * 10) >= ($missionsLength + 10)) {
            return $this->redirectToRoute('app_mission_index_page', ['page' => $pageCount]);
        }
        $missions = array_slice($missions, ($page - 1) * 10, 10);
        $newMissionsLength = count($missions);

        return $this->render('mission/index_page.html.twig', [
            'missions' => $missions,
            'missionsLength' => $newMissionsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/new', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MissionRepository $missionRepository): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        $lastMission = $missionRepository->findOneBy([], ['id' => 'desc']);
        $lastMissionId = $lastMission->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setTitle(ucfirst($mission->getTitle()));
            $mission->setDescription(ucfirst($mission->getDescription()));
            $mission->setCountry(ucwords($mission->getCountry()));
            $mission->setCodeName(strtoupper('MS-'.(substr($mission->getCountry(), 0, 3)).'-'.sprintf("%03d", (intval($lastMissionId) + 1))));
            $missionRepository->add($mission);
            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mission_show', methods: ['GET'])]
    public function show(Mission $mission): Response
    {
        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, MissionRepository $missionRepository): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setTitle(ucfirst($mission->getTitle()));
            $mission->setDescription(ucfirst($mission->getDescription()));
            $mission->setCountry(ucwords($mission->getCountry()));
            $missionRepository->add($mission);
            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_mission_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission, MissionRepository $missionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $missionRepository->remove($mission);
        }

        return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
    }
}
