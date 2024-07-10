<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;
use App\Repository\PosteoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comentario')]
class ComentarioController extends AbstractController
{
    #[Route('/', name: 'app_comentario_index', methods: ['GET'])]
    public function index(ComentarioRepository $comentarioRepository): Response
    {
        return $this->render('comentario/index.html.twig', [
            'comentarios' => $comentarioRepository->findAll(),
        ]);
    }

    #[Route('/new/{posteo_id}', name: 'app_comentario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PosteoRepository $posteoRepository, int $posteo_id, Security $security): Response
    {
        $posteo = $posteoRepository->find($posteo_id);
        if (!$posteo) {
            throw $this->createNotFoundException('The post does not exist');
        }

        $comentario = new Comentario();
        $comentario->setPosteo($posteo);

        // Get the current user
        $user = $security->getUser();
        if (!$user) {
            // Redirect to login if the user is not authenticated
            return $this->redirectToRoute('app_login');
        }

        // Set the user for the comentario
        $comentario->setUsuario($user);

        $form = $this->createForm(ComentarioType::class, $comentario);
        $comentario->setFecha(new \DateTime()); // Set the current date and time
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comentario);
            $entityManager->flush();

            return $this->redirectToRoute('app_posteo_show', ['id' => $posteo_id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comentario/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
            'posteo' => $posteo,
        ]);
    }

    #[Route('/{id}', name: 'app_comentario_show', methods: ['GET'])]
    public function show(Comentario $comentario): Response
    {
        return $this->render('comentario/show.html.twig', [
            'comentario' => $comentario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comentario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comentario $comentario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comentario/edit.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comentario_delete', methods: ['POST'])]
    public function delete(Request $request, Comentario $comentario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comentario->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comentario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
    }
}
