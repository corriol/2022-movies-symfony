<?php
// tests/Form/Type/TestedTypeTest.php
namespace App\Tests\Form;

use App\Form\GenreType;
use App\Entity\Genre;
use Symfony\Component\Form\Test\TypeTestCase;

class GenreTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'id' => 1,
            'name' => 'test',
        ];

        $model = new Genre();
        // $model will retrieve data from the form submission; pass it as the second argument

        $form = $this->factory->create(GenreType::class, $model);

        $expected = new Genre();
        $expected->setName('test');
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
/*    public function testCustomFormView()
    {
        $formData = new TestObject();
// ... prepare the data as you need

// The initial data may be used to compute custom view variables
        $view = $this->factory->create(TestedType::class, $formData)
            ->createView();

        $this->assertArrayHasKey('custom_var', $view->vars);
        $this->assertSame('expected value', $view->vars['custom_var']);
    }
}*/