<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/agents')]
class AgentController extends AbstractController
{
    #[Route('/', name: 'app_agent_index', methods: ['GET'])]
    public function index(AgentRepository $agentRepository): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $agents = $agentRepository->getAgentsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $agents = $agentRepository->getAgentsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $agents = $agentRepository->getAgentsByBirthDate();
            } elseif ($_GET["order"] == 'nationality') {
                $agents = $agentRepository->getAgentsByNationality();
            }
        } else {
            $agents = $agentRepository->getAgents();
        }

        $agentsLength = count($agents);
        if ($agentsLength > 10) {
            $agents = array_slice($agents, 0, 10);
        }
        $pageCount = substr($agentsLength, 0, -1);
        if (substr($agentsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }

        return $this->renderForm('agent/index.html.twig', [
            'agents' => $agents,
            'agentsLength' => $agentsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'app_agent_index_page')]
    public function agentsList(AgentRepository $agentRepository, int $page): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $agents = $agentRepository->getAgentsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $agents = $agentRepository->getAgentsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $agents = $agentRepository->getAgentsByBirthDate();
            } elseif ($_GET["order"] == 'nationality') {
                $agents = $agentRepository->getAgentsByNationality();
            }
        } else {
            $agents = $agentRepository->getAgents();
        }

        $agentsLength = count($agents);
        $pageCount = substr($agentsLength, 0, -1);
        if (substr($agentsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        if ($page == 1 || $agentsLength <= 10) {
            return $this->redirectToRoute('app_agent_index');
        }
        if (($page * 10) >= ($agentsLength + 10)) {
            return $this->redirectToRoute('app_agent_index_page', ['page' => $pageCount]);
        }
        $agents = array_slice($agents, ($page - 1) * 10, 10);
        $newAgentsLength = count($agents);

        return $this->render('agent/index_page.html.twig', [
            'agents' => $agents,
            'agentsLength' => $newAgentsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/new', name: 'app_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgentRepository $agentRepository): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);
        $lastAgent = $agentRepository->findOneBy([], ['id' => 'desc']);
        $lastAgentId = $lastAgent->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setLastName(ucwords($agent->getLastName()));
            $agent->setFirstName(ucwords($agent->getFirstName()));
            $agent->setIdentificationCode(intval($lastAgentId) + 101);
            $agent->setNationality(ucwords($agent->getNationality()));
            $agentRepository->add($agent);
            return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agent/new.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agent_show', methods: ['GET'])]
    public function show(Agent $agent): Response
    {
        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agent $agent, AgentRepository $agentRepository): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setLastName(ucwords($agent->getLastName()));
            $agent->setFirstName(ucwords($agent->getFirstName()));
            $agent->setNationality(ucwords($agent->getNationality()));
            $agentRepository->add($agent);
            return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agent/edit.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_agent_delete', methods: ['POST'])]
    public function delete(Request $request, Agent $agent, AgentRepository $agentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $agentRepository->remove($agent);
        }

        return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
    }
}
