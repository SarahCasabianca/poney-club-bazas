<?php

namespace App\Controller;

use App\Repository\HorseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CavalerieController extends AbstractController
{
    #[Route('/cavalerie', name: 'app_cavalerie')]
    public function index(HorseRepository $horseRepository): Response
    {
        return $this->render('cavalerie/index.html.twig', [
            'horses' => $horseRepository->findAllWithImage(),
        ]);
    }
}