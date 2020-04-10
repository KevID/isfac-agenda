<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\AgendaComment;
use App\Form\AgendaCommentType;
use App\Form\AgendaType;
use App\Repository\AgendaRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage", methods={"GET"})
     */
    public function index(AgendaRepository $agendaRepository): Response
    {
        return $this->render('agenda/index.html.twig', [
            'agendas' => $agendaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/agenda/{id}", name="agenda_show", methods={"GET"})
     */
    public function show(Agenda $agenda): Response
    {
        return $this->render('agenda/show.html.twig', [
            'agenda' => $agenda,
        ]);
    }

    /**
     * @Route("/agenda/{id}/comment/new", name="agenda_comment_new", methods={"GET","POST"})
     *
     * @throws \Exception
     */
    public function comment(Request $request, Agenda $agenda): Response
    {
        $agendaComment = new AgendaComment();
        $form = $this->createForm(AgendaCommentType::class, $agendaComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agendaComment->setCreatedAt(new DateTime());
            $user = $this->getUser();
            $agendaComment->setUser($user);
            $agendaComment->setAgenda($agenda);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agendaComment);
            $entityManager->flush();

            return $this->redirectToRoute('agenda_show', ['id' => $agenda->getId()]);
        }

        return $this->render('agenda_comment/new.html.twig', [
            'agenda' => $agenda,
            'agenda_comment' => $agendaComment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/agenda", name="agenda_backoffice", methods={"GET"})
     */
    public function indexBackoffice(AgendaRepository $agendaRepository): Response
    {
        $user = $this->getUser();

        return $this->render('backoffice/agenda/index.html.twig', [
            'agendas' => $agendaRepository->findBy(['user' => $user], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/backoffice/agenda/new", name="agenda_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $agenda = new Agenda();
        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $agenda->setUser($user);
            $agenda->setUpdatedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agenda);
            $entityManager->flush();

            return $this->redirectToRoute('agenda_backoffice');
        }

        return $this->render('backoffice/agenda/new.html.twig', [
            'agenda' => $agenda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/agenda/{id}/edit", name="agenda_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Agenda $agenda): Response
    {
        $this->denyAccessUnlessGranted('AGENDA_EDIT', $agenda);

        $form = $this->createForm(AgendaType::class, $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agenda_backoffice');
        }

        return $this->render('backoffice/agenda/edit.html.twig', [
            'agenda' => $agenda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/agenda/{id}", name="agenda_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agenda $agenda): Response
    {
        $this->denyAccessUnlessGranted('AGENDA_EDIT', $agenda);

        if ($this->isCsrfTokenValid('delete'.$agenda->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agenda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agenda_backoffice');
    }
}
