<?php

namespace App\Controller;

use App\Entity\Posteo;
use App\Entity\Comentario;
use App\Form\PosteoType;
use App\Form\ComentarioType;
use App\Repository\PosteoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/posteo')]
class PosteoController extends AbstractController
{
    #[Route('/', name: 'app_posteo_index', methods: ['GET'])]
    public function index(PosteoRepository $posteoRepository): Response
    {
        return $this->render('posteo/index.html.twig', [
            'posteos' => $posteoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_posteo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();
        if (!$user) {
            // Redirect to login page if the user is not authenticated
            $this->addFlash('error', 'You must be logged in to create a post.');
            return $this->redirectToRoute('app_login');
        }


        $posteo = new Posteo();
        $form = $this->createForm(PosteoType::class, $posteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteo->setUsuario($user);
            $entityManager->persist($posteo);
            $entityManager->flush();

            return $this->redirectToRoute('app_posteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posteo/new.html.twig', [
            'posteo' => $posteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posteo_show', methods: ['GET'])]
    public function show(Posteo $posteo, EntityManagerInterface $entityManager): Response
    {
        $comentarios = $entityManager->getRepository(Comentario::class)->findBy(['posteo' => $posteo]);
        return $this->render('posteo/show.html.twig', [
            'posteo' => $posteo,
            'comentarios' => $comentarios
        ]);
    }

    #[Route('/{id}/edit', name: 'app_posteo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posteo $posteo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PosteoType::class, $posteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_posteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posteo/edit.html.twig', [
            'posteo' => $posteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posteo_delete', methods: ['POST'])]
    public function delete(Request $request, Posteo $posteo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $posteo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($posteo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posteo_index', [], Response::HTTP_SEE_OTHER);
    }
}
