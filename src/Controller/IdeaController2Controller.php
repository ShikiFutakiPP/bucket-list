<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/idea/controller2")
 */
class IdeaController2Controller extends AbstractController
{

    /**
     * @Route("/", name="app_idea_controller2_index", methods={"GET"})
     */
    public function index(IdeaRepository $ideaRepository): Response
    {
        return $this->render('idea_controller2/index.html.twig', [
            'ideas' => $ideaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_idea_controller2_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IdeaRepository $ideaRepository): Response
    {

        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->add($idea, true);

            return $this->redirectToRoute('app_idea_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea_controller2/new.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_idea_controller2_show", methods={"GET"})
     */
    public function show(Idea $idea): Response
    {
        return $this->render('idea_controller2/show.html.twig', [
            'idea' => $idea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_idea_controller2_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Idea $idea, IdeaRepository $ideaRepository): Response
    {
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->add($idea, true);

            return $this->redirectToRoute('app_idea_controller2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea_controller2/edit.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_idea_controller2_delete", methods={"POST"})
     */
    public function delete(Request $request, Idea $idea, IdeaRepository $ideaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idea->getId(), $request->request->get('_token'))) {
            $ideaRepository->remove($idea, true);
        }

        return $this->redirectToRoute('app_idea_controller2_index', [], Response::HTTP_SEE_OTHER);
    }
}
