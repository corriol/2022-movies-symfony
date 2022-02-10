<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;
use App\Repository\RatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiRatingController extends AbstractController
{
    /**
     * @Route("/api/rating/{movie}/{user}", name="api_rating", methods = {"GET"})
     */
    public function index(Movie $movie, User $user, RatingRepository $ratingRepository): Response
    {
        $value = 0;
        // busquem si l'usuari ja ha valorat la pel·lícula
        $rating = $ratingRepository->findOneBy(["movie"=>$movie, "user"=>$user]);

        if ($rating !== null) {
            $value = $rating->getValue() * 20;
        }

        $data = ["value" => $value];

        return $this->json($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/rating", name="api_rating_update", methods = {"POST"})
     */
    public function update(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $userId = $data["user"];
        $movieId = $data["movie"];
        $value = $data["value"];

        $user = $em->getRepository(User::class)->find($userId);
        $movie = $em->getRepository(Movie::class)->find($movieId);

        // busquem si l'usuari ja ha valorat la pel·lícula

        $rating = $em->getRepository(Rating::class)->findOneBy(["movie"=>$movie, "user"=>$user]);

        if ($rating !== null) {
            $rating->setValue(floor($value/20));
        } else {
            $rating = new Rating();
            $rating->setMovie($movie);
            $rating->setUser($user);
            $rating->setValue(floor($value/20));
        }

        $em->persist($rating);
        $em->flush();

        $data = ["value" => $value];

        return $this->json($data, Response::HTTP_OK);
    }




}
