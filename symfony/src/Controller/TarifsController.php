<?php

namespace App\Controller;

use App\Repository\ConfigurationRepository;
use App\Repository\RateCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TarifsController extends AbstractController
{
    #[Route('/tarifs', name: 'app_tarifs')]
    public function index(
        RateCategoryRepository $rateCategoryRepository,
        ConfigurationRepository $configurationRepository,
    ): Response {
        return $this->render('tarifs/index.html.twig', [
            'categories' => $rateCategoryRepository->findAllWithRates(),
            'season' => $configurationRepository->getValue('rates_season'),
        ]);
    }
}