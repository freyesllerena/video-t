<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/03/2018
 * Time: 00:53
 */

namespace App\Controller;


use App\Form\FilmType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Film;

/**
 * Class FilmsController
 * @package App\Controller
 */
class FilmsController
{

    /**
     * @Route ("/")
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index (Environment $twig) {

        return new Response($twig->render('films/welcome.html.twig'));
    }


    /**
     * Form Film
     * @Route ("/films", name="films")
     * @param Request $request
     * @param Environment $twig
     * @param RegistryInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function films (Request $request, Environment $twig, RegistryInterface $doctrine, FormFactoryInterface $formFactory) {
        $films = $doctrine->getRepository(Film::class)->findAll();
        $form = $formFactory->createBuilder(FilmType::class, $films[0])->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getEntityManager()->flush();
        }

        return new Response($twig->render('films/films.html.twig', [
                'films' => $films,
                'form' => $form->createView()
            ]
        ));
    }
}