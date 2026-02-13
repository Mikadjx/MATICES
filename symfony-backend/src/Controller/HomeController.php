<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use App\Repository\VideoRepository;
use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        PhotoRepository $photoRepository,
        VideoRepository $videoRepository,
        SongRepository $songRepository
    ): Response {
        // Photos visibles triées par position puis date décroissante
        $photos = $photoRepository->findBy(
            ['isVisible' => true],
            ['position' => 'ASC', 'eventDate' => 'DESC']
        );

        // Vidéos visibles triées par position puis date décroissante
        $videos = $videoRepository->findBy(
            ['isVisible' => true],
            ['position' => 'ASC', 'createdAt' => 'DESC']
        );

        // Chansons visibles triées par position
        $songs = $songRepository->findBy(
            ['isVisible' => true],
            ['position' => 'ASC']
        );

        return $this->render('home/index.html.twig', [
            'photos' => $photos,
            'videos' => $videos,
            'songs'  => $songs,
        ]);
    }
}