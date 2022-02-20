<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use Symfony\UX\Cropperjs\Form\CropperType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MovieRepository $movieRepository, GenreRepository $genreRepository, CropperInterface $cropper): Response
    {
        $movies = $movieRepository->findAll();

        // obtinc les 8 pel·lícues més noves ordenades per data d'estrena
        $movies = $movieRepository->findBy([], ["releaseDate"=>"DESC"], 8);

        // obtinc els generes per ordre alfabètic
        $genres = $genreRepository->findBy([], ["name"=>"ASC"]);

        $rating = new Rating();


        return $this->render('default/index.html.twig', [
            'movies' => $movies,
            'genres' => $genres
        ]);
    }

    /**
     * @Route("/react", name="home_react")
     */
    public function react(MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('default/react.html.twig',
        ['movies'=>$movies]);
    }
}
