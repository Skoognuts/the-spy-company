<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/contacts')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $contacts = $contactRepository->getContactsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $contacts = $contactRepository->getContactsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $contacts = $contactRepository->getContactsByBirthDate();
            } elseif ($_GET["order"] == 'codeName') {
                $contacts = $contactRepository->getContactsByCodeName();
            } elseif ($_GET["order"] == 'nationality') {
                $contacts = $contactRepository->getContactsByNationality();
            }
        } else {
            $contacts = $contactRepository->getContacts();
        }
        
        $contactsLength = count($contacts);
        if ($contactsLength > 10) {
            $contacts = array_slice($contacts, 0, 10);
        }
        $pageCount = substr($contactsLength, 0, -1);
        if (substr($contactsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'contactsLength' => $contactsLength,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/page-{page}', name: 'app_contact_index_page')]
    public function contactsList(ContactRepository $contactRepository, int $page): Response
    {
        if (isset($_GET["order"])) {
            if ($_GET["order"] == 'lastName') {
                $contacts = $contactRepository->getContactsByLastName();
            } elseif ($_GET["order"] == 'firstName') {
                $contacts = $contactRepository->getContactsByFirstName();
            } elseif ($_GET["order"] == 'dateOfBirth') {
                $contacts = $contactRepository->getContactsByBirthDate();
            } elseif ($_GET["order"] == 'codeName') {
                $contacts = $contactRepository->getContactsByCodeName();
            } elseif ($_GET["order"] == 'nationality') {
                $contacts = $contactRepository->getContactsByNationality();
            }
        } else {
            $contacts = $contactRepository->getContacts();
        }

        $contactsLength = count($contacts);
        $pageCount = substr($contactsLength, 0, -1);
        if (substr($contactsLength, -1) == 0) {
            $pageCount = (int)$pageCount;
        } else {
            $pageCount = (int)$pageCount + 1;
        }
        if ($page == 1 || $contactsLength <= 10) {
            return $this->redirectToRoute('app_contact_index');
        }
        if (($page * 10) >= ($contactsLength + 10)) {
            return $this->redirectToRoute('app_contact_index_page', ['page' => $pageCount]);
        }
        $contacts = array_slice($contacts, ($page - 1) * 10, 10);
        $newContactsLength = count($contacts);

        return $this->render('contact/index_page.html.twig', [
            'contacts' => $contacts,
            'contactsLength' => $newContactsLength,
            'page' => $page,
            'pageCount' => $pageCount
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setLastName(ucwords($contact->getLastName()));
            $contact->setFirstName(ucwords($contact->getFirstName()));
            $contact->setNationality(ucwords($contact->getNationality()));
            $contact->setCodeName(ucwords($contact->getCodeName()));
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setLastName(ucwords($contact->getLastName()));
            $contact->setFirstName(ucwords($contact->getFirstName()));
            $contact->setNationality(ucwords($contact->getNationality()));
            $contact->setCodeName(ucwords($contact->getCodeName()));
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
