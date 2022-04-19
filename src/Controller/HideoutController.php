<?php

namespace App\Controller;

use App\Entity\Hideout;
use App\Form\HideoutType;
use App\Repository\HideoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/hideouts')]
class HideoutController extends AbstractController
{
    #[Route('/', name: 'app_hideout_index', methods: ['GET'])]
    public function index(HideoutRepository $hideoutRepository): Response
    {
        $hideouts = $hideoutRepository->getHideouts();
        $hideoutsLength = count($hideouts);
        if ($hideoutsLength > 10) {
            $hideouts = array_slice($hideouts, 0, 10);
        }
        $pageCount = substr($hideoutsLength, 0, -1);
        if (substr($hideoutsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        return $this->render('hideout/index.html.twig', [
            'hideouts' => $hideouts,
            'hideoutsLength' => $hideoutsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'app_hideout_index_page')]
    public function hideoutsList(HideoutRepository $hideoutRepository, int $page): Response
    {
        $hideouts = $hideoutRepository->getHideouts();
        $hideoutsLength = count($hideouts);
        $pageCount = substr($hideoutsLength, 0, -1);
        if (substr($hideoutsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        if ($page == 1 || $hideoutsLength <= 10) {
            return $this->redirectToRoute('app_hideout_index');
        }
        if (($page * 10) >= ($hideoutsLength + 10)) {
            return $this->redirectToRoute('app_hideout_index_page', ['page' => $pageCount]);
        }
        $hideouts = array_slice($hideouts, ($page - 1) * 10, 10);
        $newhideoutsLength = count($hideouts);

        return $this->render('hideout/index_page.html.twig', [
            'hideouts' => $hideouts,
            'hideoutsLength' => $newhideoutsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/new', name: 'app_hideout_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HideoutRepository $hideoutRepository): Response
    {
        $hideout = new Hideout();
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hideout->setType(ucwords($hideout->getType()));
            $hideout->setCountry(ucwords($hideout->getCountry()));
            $hideoutRepository->add($hideout);
            return $this->redirectToRoute('app_hideout_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hideout/new.html.twig', [
            'hideout' => $hideout,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hideout_show', methods: ['GET'])]
    public function show(Hideout $hideout): Response
    {
        return $this->render('hideout/show.html.twig', [
            'hideout' => $hideout,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hideout_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hideout $hideout, HideoutRepository $hideoutRepository): Response
    {
        $form = $this->createForm(HideoutType::class, $hideout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hideout->setType(ucwords($hideout->getType()));
            $hideout->setCountry(ucwords($hideout->getCountry()));
            $hideoutRepository->add($hideout);
            return $this->redirectToRoute('app_hideout_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hideout/edit.html.twig', [
            'hideout' => $hideout,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_hideout_delete', methods: ['POST'])]
    public function delete(Request $request, Hideout $hideout, HideoutRepository $hideoutRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hideout->getId(), $request->request->get('_token'))) {
            $hideoutRepository->remove($hideout);
        }

        return $this->redirectToRoute('app_hideout_index', [], Response::HTTP_SEE_OTHER);
    }
}
