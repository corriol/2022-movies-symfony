<?php

namespace App\Tests\Entity;

use App\Entity\Movie;
use App\Entity\Genre;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class MovieTest extends KernelTestCase
{
    
    protected function setUp(): void
    {
        self::bootKernel();

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /** 
     * @dataProvider getMovies()
     */

    public function testMovieValidation(Movie $movie, int $numberOfViolations): void {
        $container = static::getContainer();
        $validator = $container->get(ValidatorInterface::class);
        $violations = $validator->validate($movie);     

        $this->assertEquals(count($violations), $numberOfViolations);
    }

    public function getMovies() {
        
        $movie = new Movie();        
        $movie->setTitle("Hola");
        $movie->setOverview("Potser una gran película");    
        $movie->setPoster("poster.jpg");
        $movie->setGenre(new Genre());
        $movie->setReleaseDate(new \DateTime("2022-01-20"));

        yield "Pel·lícula amb totes les dades correctes" => [$movie, 0];

        $movie = new Movie();
        $movie->setTitle("");
        $movie->setOverview("");
        $movie->setPoster("");
        $movie->setGenre(null);
        $movie->setReleaseDate(new \DateTime());

        yield "Pel·lícula amb totes les dades errònies" => [$movie, 4];

    }
}
