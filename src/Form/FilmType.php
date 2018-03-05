<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label' => 'Titre : '
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description : '
            ))
            ->add('categorie', EntityType::class, array(
                'label' => 'Catégorie : ',
                'class' => Categorie::class,
                'choice_label' => 'name',
            ));

            $photo = $builder->getData()->getPhoto();
            if ($photo) {
                $builder
                    ->add('photo',FileType::class, array(
                        'label' => 'Affiche du film au format JPG : ',
                        'mapped'=>false,
                        'required'=> false,
                        'data_class'=>null
                    ));

            } else {

                $builder
                    ->add('photo', FileType::class, array(
                        'label' => 'Affiche du film au format JPG : '
                    ));
            }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
