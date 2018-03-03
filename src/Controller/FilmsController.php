<?php

/**
 * Created by PhpStorm.
 * User: myentreprise
 * Date: 03/03/2018
 * Time: 00:53
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FilmsController
 * @package App\Controller
 */
class FilmsController extends Controller
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
     * @Route ("/films", name="films")
     * @param RegistryInterface $doctrine
     * @param Environment $twig
     * @return Response
     */
    public function films (RegistryInterface $doctrine, Environment $twig) {
        $films = $doctrine->getRepository(Film::class)->findAll();

        return $this->render('films/films.html.twig', compact('films'));
    }
}