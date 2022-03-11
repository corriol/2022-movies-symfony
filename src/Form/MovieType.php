<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Presta\ImageBundle\Form\Type\ImageType;

class MovieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title')
            ->add('overview')
            ->add('releaseDate')
            ->add('voters')
            ->add('rating')
            ->add('posterFile', ImageType::class,
                ["max_width" => 180*2, "max_height"=>320*2])
            ->add('genre', EntityType::class,
                ['class' => Genre::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select a genre',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
/*[
'required' => false,
'allow_delete' => true,
'delete_label' => '...',
'download_label' => '...',
'download_uri' => true,
'image_uri' => true,
'imagine_pattern' => 'my_thumb',
'asset_helper' => true,
]*/
}
