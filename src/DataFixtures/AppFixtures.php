<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private Generator $faker;
    private ParameterBagInterface $parameterBag; 

    public function __construct(UserPasswordHasherInterface $hasher, ParameterBagInterface $parameterBag)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create();
        $this->parameterBag = $parameterBag;
    }

    public function load(ObjectManager $manager): void
    {
        //guarde en un array  els gèneres per després poder-los assignar a les pel·lícules.
        $genres = [];

        // Generes
        for ($i=0; $i<4; $i++ ) {
            $genre = new Genre();
            $genre->setName(ucwords($this->faker->word()));
            $manager->persist($genre);
            $genres[] = $genre;
        }
        $manager->flush();

        // Usuari amb rol d'administrador
        $user = new User();
        $user->setUsername('admin');

        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRole("ROLE_ADMIN");

        $manager->persist($user);
        
        $users[] = $user;

        // Usuari amb rol d'editor
        $user = new User();
        $user->setUsername('editor');

        $password = $this->hasher->hashPassword($user, 'editor');
        $user->setPassword($password);
        $user->setRole("ROLE_EDITOR");

        $manager->persist($user);

        $users[] = $user;


        // Usuari amb rol d'usuari
        $user = new User();
        $user->setUsername('user');

        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $user->setRole("ROLE_USER");

        $manager->persist($user);

        $users[] = $user;

        // apliquem els canvis a la base de dades
        $manager->flush();


        // Pel·lícules
        for ($i=0; $i<14; $i++ ) {
            $movie = new Movie();
            $movie->setTitle(ucwords($this->faker->words(3, true)));
            $movie->setOverview($this->faker->text(500));
            $movie->setReleaseDate($this->faker->dateTime);
            $movie->setPoster($this->faker->file('assets', 'public/'. 
                $this->parameterBag->get('app_path_posters'), false));
            $movie->setGenre($genres[\array_rand($genres)]);
            $movie->setUser($users[\array_rand($users)]);
            $manager->persist($movie);
        }
        $manager->flush();       
        
    }
}
