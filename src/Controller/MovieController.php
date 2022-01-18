<?php

namespace App\Controller;

use App\Entity\Movie;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/movies/create", name="movies_create")
     */
    public function create(ManagerRegistry $managerRegistry)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $movie = new Movie();
        $movie->setTitle("Ava");
        $movie->setOverview("A black ops assassin is forced to fight for her 
        own survival after a job goes dangerously wrong.");
        $movie->setReleaseDate(new DateTime("2020-09-25"));
        $movie->setPoster("noposter.jpg");

        $entityManager->persist($movie);
        $entityManager->flush();
        return new Response("The movie with id " . $movie->getId().
            " has been inserted successfully!" );
    }

}