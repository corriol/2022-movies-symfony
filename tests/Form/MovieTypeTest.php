<?php

namespace App\Tests\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Component\Form\Test\TypeTestCase;

class MovieTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'id' => 1,
            'title' => 'Hola',
            'overview' => "Potser una gran pel·lícula",
            'poster' => "poster.jpg",
            'genre' => new Genre(),
            'releaseDate' => new \DateTime("2022-01-20"),
        ];

        $model = new Movie();

        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(MovieType::class, $model);

        $expected = new Movie();
        $expected->setTitle("Hola");
        $expected->setOverview("Potser una gran pel·lícula");
        $expected->setPoster("poster.jpg");
        $expected->setGenre(new Genre());
        $expected->setReleaseDate(new \DateTime("2022-01-20"));
        // submit the data to the form directly

        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
