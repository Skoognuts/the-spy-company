<?php

namespace App\Controller;

use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\SpecialtyRepository;
use App\Repository\TargetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(AgentRepository $agentRepository, ContactRepository $contactRepository, HideoutRepository $hideoutRepository, MissionRepository $missionRepository, SpecialtyRepository $specialtyRepository, TargetRepository $targetRepository)
    {
        $this->agents = $agentRepository->getAgents();
        $this->contacts = $contactRepository->getContacts();
        $this->hideouts = $hideoutRepository->getHideouts();
        $this->missions = $missionRepository->getMissions();
        $this->specialties = $specialtyRepository->getSpecialties();
        $this->targets = $targetRepository->getTargets();
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $agentsLength = count($this->agents);
        $contactsLength = count($this->contacts);
        $hideoutsLength = count($this->hideouts);
        $missionsLength = count($this->missions);
        $specialtiesLength = count($this->specialties);
        $targetsLength = count($this->targets);

        return $this->render('admin/index.html.twig', [
            'agentsLength' => $agentsLength,
            'contactsLength' => $contactsLength,
            'hideoutsLength' => $hideoutsLength,
            'missionsLength' => $missionsLength,
            'specialtiesLength' => $specialtiesLength,
            'targetsLength' => $targetsLength
        ]);
    }
}
