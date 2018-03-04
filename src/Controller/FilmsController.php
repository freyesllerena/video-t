<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/03/2018
 * Time: 00:53
 */

namespace App\Controller;


use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Film;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * Class FilmsController
 * @package App\Controller
 */
class FilmsController extends Controller
{

    /**
     * @Route ("/", name="homepage")
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
     * Films
     *
     * @Route ("/films", name="film_list")
     * @param Request $request
     * @param Environment $twig
     * @param RegistryInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function list (Request $request, Environment $twig, RegistryInterface $doctrine, FormFactoryInterface $formFactory) {

        $films = $doctrine->getRepository(Film::class)->findAll();
        $form = $formFactory->createBuilder(FilmType::class, $films[0])->getForm();

        $form->handleRequest($request);


        // Creating pagnination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $films,
            $request->query->get('page', 1),
            10
        );


        return new Response($twig->render('films/films.html.twig', [
                'films' => $films,
                'pagination' => $pagination
            ]
        ));
    }

    /**
     * Form Film new
     *
     * @Route ("/films/new", name="film_new")
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
    public function new (Request $request, Environment $twig, RegistryInterface $doctrine, FormFactoryInterface $formFactory) {

        $film = new Film();
        $form = $formFactory->createBuilder(FilmType::class, $film)->getForm();

        $form->add('submit', SubmitType::class, [
            'label' => 'Nouveau',
            'attr' => ['class' => 'btn btn-default pull-right'], ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->getData()->getTitre()) {
                $film->setTitre($form->getData()->getTitre()) ;
            }

            if ($form->getData()->getDescription()) {
                $film->setDescription($form->getData()->getDescription()) ;
            }

            if ($form->getData()->getCategorie()) {
                $film->setCategorie($form->getData()->getCategorie()) ;
            }

            if ($form->getData()->getPhoto()) {
                $film->setPhoto($form->getData()->getPhoto()) ;
            }

            $doctrine->getEntityManager()->persist($film);
            $doctrine->getEntityManager()->flush();

            return $this->redirectToRoute('film_list');
        }

        return new Response($twig->render('films/film.html.twig', [
                'form' => $form->createView()
            ]
        ));
    }

    /**
     * Form Film edit
     *
     * @Route("/films/edit/{id}", name="films_edit", requirements={"id"="\d+"})
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
    public function edit (Request $request, Environment $twig, RegistryInterface $doctrine, FormFactoryInterface $formFactory) {
        $films = $doctrine->getRepository(Film::class)->findOneBy(['id' => $request->get('id')]);
        if (!is_null($films)) {

            $form = $formFactory->createBuilder(FilmType::class, $films)->getForm();

            $form->add('submit', SubmitType::class, [
                'label' => 'Edit',
                'attr' => ['class' => 'btn btn-default pull-right'], ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                $doctrine->getEntityManager()->flush();

                return $this->redirectToRoute('film_list');
            }

            return new Response($twig->render('films/film.html.twig', [
                    'form' => $form->createView()
                ]
            ));

        }
    }

    /**
     * remove Film
     *
     * @Route("/films/remove/{id}", name="films_remove", requirements={"id"="\d+"})
     * @param Film $film
     * @param RegistryInterface $doctrine
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (Film $film, RegistryInterface $doctrine) {

        $doctrine->getEntityManager()->remove($film);
        $doctrine->getEntityManager()->flush();

        return $this->redirectToRoute('film_list');
    }
}