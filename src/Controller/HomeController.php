<?php

namespace App\Controller;

use App\Repository\PosteoRepository;
use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, PosteoRepository $posteoRepository, EntityManagerInterface $entityManager): Response
    {
        $categoriaId = $request->query->get('categoria');
        $posteos =         // Fetch posteos ordered by newest first, either filtered by categoria or all
            $posteos = $posteoRepository->findBy(
                $categoriaId ? ['categoria' => $categoriaId] : [],
                ['fecha' => 'DESC']
            );

        $categorias = $entityManager->getRepository(Categoria::class)->findAll();

        return $this->render('home.html.twig', [
            'posteos' => $posteos,
            'categorias' => $categorias,
            'selectedCategoria' => $categoriaId,
        ]);
    }
}
