<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/03/2018
 * Time: 00:53
 */

namespace App\Controller;


use App\Entity\Compteur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        $something = (object)[
            'categorie' => null,
            'create' => false
        ];
        /** @var FilmRepository $filmRepo */
        $filmRepo = $doctrine->getRepository(Film::class);
        $filmQuery = $filmRepo->queryFilmsBySomething($something);
        // Création de la pagnination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $filmQuery,
            $request->query->get('page', 1),
            10
        );


        return new Response($twig->render('films/films.html.twig', [
                'pagination' => $pagination,
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
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function new (Request $request, Environment $twig, RegistryInterface $doctrine, FormFactoryInterface $formFactory, \Swift_Mailer $mailer) {

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

            if ($form->getData()->getCategorie()->getName()) {
                $film->setCategorie($form->getData()->getCategorie()->getName()) ;
            }

            if ($form->getData()->getPhoto()) {


                // $file stores the uploaded PDF file
                /** @var UploadedFile $file */
                $file = $film->getPhoto();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('posters_directory'),
                    $fileName
                );

                $film->setPhoto($fileName) ;
            }

            $film->setDateInsertion(new \DateTime());

            $doctrine->getEntityManager()->persist($film);
            $doctrine->getEntityManager()->flush();

            // mise à jour table compteur
            $this->updateCompteur($doctrine);

            // Envoi du mail à l'administrateur
            $subject = 'Sjout du nouveau film ' .$form->getData()->getTitre();
            $msg =  "Le nouveau film ".$form->getData()->getTitre()." a bien été ajouté";
            $this->sendMailToAdmin($subject, $msg, $mailer);


            return $this->redirectToRoute('film_list', [
                'id' => $film->getId()
            ]);
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

        $film = $doctrine->getRepository(Film::class)->findOneBy(['id' => $request->get('id')]);
        if (!is_null($film)) {


            $form = $formFactory->createBuilder(FilmType::class, $film)->getForm();

            $form->add('submit', SubmitType::class, [
                'label' => 'Edit',
                'attr' => ['class' => 'btn btn-default pull-right'], ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if ($form->getData()->getCategorie()->getName()) {
                    $film->setCategorie($form->getData()->getCategorie()->getName()) ;
                }

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
     * Remove film
     *
     * @Route("/films/remove/{id}", name="films_remove", requirements={"id"="\d+"})
     * @param Film $film
     * @param RegistryInterface $doctrine
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete (Film $film, RegistryInterface $doctrine, \Swift_Mailer $mailer) {
        $titre = $film->getTitre();
        $doctrine->getEntityManager()->remove($film);
        $doctrine->getEntityManager()->flush();

        // Mise à jour table compteur
        $this->updateCompteur($doctrine);

        // Envoi du mail à l'administrateur
        $subject = 'Suppression du film' .$titre;
        $msg =  'Le film '.$titre.' a bien été supprimé';
        $this->sendMailToAdmin($subject, $msg, $mailer);

        return $this->redirectToRoute('film_list');
    }

    /**
     * @param RegistryInterface $doctrine
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function updateCompteur(RegistryInterface $doctrine) {
        // mise à jour table compteur
        $compteur = $doctrine->getRepository(Compteur::class)->findOneBy(['id' => 1]);
        if (is_null($compteur)) {
            $compteur = new Compteur();
        }
        $countFilms =  count($doctrine->getRepository(Film::class)->findAll());
        $compteur->setTotal($countFilms);
        $doctrine->getEntityManager()->persist($compteur);
        $doctrine->getEntityManager()->flush();
    }

    /**
     * Envoi du mail à l'administrateur
     * @param $subject
     * @param $msg
     * @param \Swift_Mailer $mailer
     */
    private function sendMailToAdmin($subject, $msg, $mailer) {
        $administrateurEmail = $this->getParameter('delivery_addresses');
        $message = (new \Swift_Message($subject))
            ->setFrom(['testtransmision2014@gmail.com' => 'Fidel REYES'])
            ->setTo($administrateurEmail)
            ->setBody($msg);

        $mailer->send($message);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}