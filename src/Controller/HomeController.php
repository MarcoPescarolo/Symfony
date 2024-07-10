<?php

namespace App\Controller;

use App\Repository\PosteoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PosteoRepository $posteoRepository): Response
    {
        $posteos = $posteoRepository->findBy([], ['fecha' => 'DESC'], 10);

        return $this->render('home.html.twig', [
            'posteos' => $posteos,
        ]);
    }
}
