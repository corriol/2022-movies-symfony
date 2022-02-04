<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\RatingRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/movies/create", name="movies_create")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $movie = new Movie();

        // Una vegada creada la instància podem afegim valors per defecte
        // en aquest cas la data i el poster
        $movie->setReleaseDate(new DateTime());
        $movie->setPoster("noposter.jpg");

        $form = $this->createFormBuilder($movie)
            ->add('title', TextType::class)
            ->add('overview', TextareaType::class)
            ->add('releaseDate', DateType::class)
            ->add('poster', TextType::class)
            ->add('genre', EntityType::class, ['class' =>
                Genre::class, 'choice_label' => 'name'])
            ->add('create', SubmitType::class, array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();

            $em->persist($movie);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('movie/create.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/movies/{id}/edit", name="movies_edit")
     */
    public function edit(int $id, Request $request, EntityManagerInterface $em)    {

        $movieRepository = $em->getRepository(Movie::class);
        $movie = $movieRepository->find($id);

        $form = $this->createFormBuilder($movie)
            ->add('id', HiddenType::class)
            ->add('title', TextType::class)
            ->add('tagline', TextType::class)
            ->add('overview', TextareaType::class)
            ->add('releaseDate', DateType::class,
                ['widget' => "single_text"]
            )
            ->add('poster', TextType::class)
            ->add('genre', EntityType::class,
                ['class' => Genre::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select a genre',
                ]
            )
            ->add('update', SubmitType::class, array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $em->persist($movie);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('movie/edit.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/movies/{id}", name="movies_show", requirements={"id"="\d+"})
     */
    public function show(Movie $movie, Request $request, RatingRepository $ratingRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        dump($user->getRatings());
        dump($user->getMovies());

        // busquem si l'usuari ja ha valorat la pel·lícula
        $rating = $ratingRepository->findOneBy(["movie"=>$movie, "user"=>$user]);

        // si no creem el rating
        if (empty($rating)) {
            $rating = new Rating();
            $rating->setMovie($movie);
            $rating->setUser($user);
        } else
            $oldValue = $rating->getValue();


        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // Si es una votació nova
            if ($rating->getId() === null) {
                $newRating = ($movie->getRating() * $movie->getVoters() + $rating->getValue()) / ($movie->getVoters() + 1);
                $movie->setVoters($movie->getVoters() + 1);
            } else {
                $newRating = ($movie->getRating() * $movie->getVoters() + $rating->getValue() - $oldValue)/($movie->getVoters());
            }

            $movie->setRating($newRating);
            
            $em->persist($movie);
            $em->persist($rating);

            $em->flush();

            $this->addFlash('success', 'La teua valoració s\'ha guardat!');
        }

        if ($movie) {
            return $this->render('movie/show.html.twig',
                [
                    'movie' => $movie,
                    'form' => $form->createView()
                ]
            );
        }
    }

}