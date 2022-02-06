<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MovieRepository $movieRepository, GenreRepository $genreRepository): Response
    {
        $movies = $movieRepository->findAll();

        // obtinc les 8 pel·lícues més noves ordenades per data d'estrena
        $movies = $movieRepository->findBy([], ["releaseDate"=>"DESC"], 8);

        // obtinc els generes per ordre alfabètic
        $genres = $genreRepository->findBy([], ["name"=>"ASC"]);

        $rating = new Rating();

        //*$rating->setMovie($movie[0]);
        //*$rating->setUser($user);*/


//        $form = $this->createForm(RatingType::class, $rating);

        return $this->render('default/index.html.twig', [
            'movies' => $movies,
            'genres' => $genres,
  //          'rateForm' => $form->createView()
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
