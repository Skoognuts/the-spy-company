<?php

namespace App\Controller;

use App\Entity\Target;
use App\Form\TargetType;
use App\Repository\TargetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/targets')]
class TargetController extends AbstractController
{
    #[Route('/', name: 'app_target_index', methods: ['GET'])]
    public function index(TargetRepository $targetRepository): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $targets = $targetRepository->getTargetsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $targets = $targetRepository->getTargetsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $targets = $targetRepository->getTargetsByBirthDate();
            } elseif ($_GET["order"] == 'codeName') {
                $targets = $targetRepository->getTargetsByCodeName();
            } elseif ($_GET["order"] == 'nationality') {
                $targets = $targetRepository->getTargetsByNationality();
            }
        } else {
            $targets = $targetRepository->getTargets();
        }

        $targetsLength = count($targets);
        if ($targetsLength > 10) {
            $targets = array_slice($targets, 0, 10);
        }
        $pageCount = substr($targetsLength, 0, -1);
        if (substr($targetsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        return $this->render('target/index.html.twig', [
            'targets' => $targets,
            'targetsLength' => $targetsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'app_target_index_page')]
    public function targetsList(TargetRepository $targetRepository, int $page): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $targets = $targetRepository->getTargetsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $targets = $targetRepository->getTargetsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $targets = $targetRepository->getTargetsByBirthDate();
            } elseif ($_GET["order"] == 'codeName') {
                $targets = $targetRepository->getTargetsByCodeName();
            } elseif ($_GET["order"] == 'nationality') {
                $targets = $targetRepository->getTargetsByNationality();
            }
        } else {
            $targets = $targetRepository->getTargets();
        }
        
        $targetsLength = count($targets);
        $pageCount = substr($targetsLength, 0, -1);
        if (substr($targetsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        if ($page == 1 || $targetsLength <= 10) {
            return $this->redirectToRoute('app_target_index');
        }
        if (($page * 10) >= ($targetsLength + 10)) {
            return $this->redirectToRoute('app_target_index_page', ['page' => $pageCount]);
        }
        $targets = array_slice($targets, ($page - 1) * 10, 10);
        $newTargetsLength = count($targets);

        return $this->render('target/index_page.html.twig', [
            'targets' => $targets,
            'targetsLength' => $newTargetsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/new', name: 'app_target_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TargetRepository $targetRepository): Response
    {
        $target = new Target();
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $target->setLastName(ucwords($target->getLastName()));
            $target->setFirstName(ucwords($target->getFirstName()));
            $target->setNationality(ucwords($target->getNationality()));
            $target->setCodeName(ucwords($target->getCodeName()));
            $targetRepository->add($target);
            return $this->redirectToRoute('app_target_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('target/new.html.twig', [
            'target' => $target,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_target_show', methods: ['GET'])]
    public function show(Target $target): Response
    {
        return $this->render('target/show.html.twig', [
            'target' => $target,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_target_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Target $target, TargetRepository $targetRepository): Response
    {
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $target->setLastName(ucwords($target->getLastName()));
            $target->setFirstName(ucwords($target->getFirstName()));
            $target->setNationality(ucwords($target->getNationality()));
            $target->setCodeName(ucwords($target->getCodeName()));
            $targetRepository->add($target);
            return $this->redirectToRoute('app_target_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('target/edit.html.twig', [
            'target' => $target,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_target_delete', methods: ['POST'])]
    public function delete(Request $request, Target $target, TargetRepository $targetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$target->getId(), $request->request->get('_token'))) {
            $targetRepository->remove($target);
        }

        return $this->redirectToRoute('app_target_index', [], Response::HTTP_SEE_OTHER);
    }
}
