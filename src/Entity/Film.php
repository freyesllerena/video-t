<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilmRepository")
 */
class Film
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Length(min=10, minMessage="Cet titre est trop court.")
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", length=1000, nullable=false)
     * @Assert\NotBlank(message = "Veuillez renseigner la description.")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="categorie", type="string", nullable=false)
     * @Assert\NotBlank(message = "Veuillez renseigner la catégorie.")
     */
    private $categorie;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $photo;

    /**
     * date d'insertion du film
     * @var datetime
     * @ORM\Column(name="date_insertion", type="datetime", nullable=true)
     * @Assert\DateTime(message = "Le format date n'est pas valide.")
     */
    private $dateInsertion;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return DateTime
     */
    public function getDateInsertion()
    {
        return $this->dateInsertion;
    }

    /**
     * @param DateTime $dateInsertion
     */
    public function setDateInsertion(DateTime $dateInsertion)
    {
        $this->dateInsertion = $dateInsertion;
    }
}
