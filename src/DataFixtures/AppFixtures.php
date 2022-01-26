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

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        //guarde en un array  els gèneres per després poder-los assignar a les pel·lícules.
        $genres = [];

        // Generes
        for ($i=0; $i<4; $i++ ) {
            $genre = new Genre();
            $genre->setName($this->faker->word());
            $manager->persist($genre);
            $genres[] = $genre;
        }
        $manager->flush();

        // Pel·lícules
        for ($i=0; $i<14; $i++ ) {
            $movie = new Movie();
            $movie->setTitle(ucwords($this->faker->words(3, true)));
            $movie->setOverview($this->faker->text(500));
            $movie->setReleaseDate($this->faker->dateTime);
            $movie->setPoster($this->faker->file('assets', 'public/images', false));
            $movie->setGenre($genres[\array_rand($genres)]);
            $manager->persist($movie);
        }
        $manager->flush();

        // Usuari amb rol d'administrador
        $user = new User();
        $user->setUsername('admin');

        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRole("ROLE_ADMIN");

        $manager->persist($user);

        // Usuari amb rol d'usuari
        $user = new User();
        $user->setUsername('user');

        $password = $this->hasher->hashPassword($user, 'user');
        $user->setPassword($password);
        $user->setRole("ROLE_USER");

        $manager->persist($user);

        // apliquem els canvis a la base de dades
        $manager->flush();
    }
}
