<?php

namespace EspritEntreAide\ClubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="EspritEntreAide\ClubBundle\Repository\ClubRepository")
 */
class Club
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_c", type="string", length=255, nullable=true)
     */
    private $nomC;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_c", type="string", length=255, nullable=true)
     */
    private $mailC;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="EspritEntreAide\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $idUser;


    /**
     * @var string
     *
     * @ORM\Column(name="desc_c", type="text", nullable=true)
     */
    private $descC;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank (message="Ajouter une image png")
     * @Assert\File(mimeTypes={ "image/png" })
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity="EspritEntreAide\EvenementBundle\Entity\Evenement", mappedBy="idClub")
     */
    private $evenements;

    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
    }



    /**
     * @ORM\ManyToMany(targetEntity="EspritEntreAide\UserBundle\Entity\User", inversedBy="clubs")
     * @ORM\JoinTable(name="membres_club")
     */
    private $membres;

    /**
     * @return mixed
     */
    public function getMembres()
    {
        return $this->membres;
    }

    /**
     * @param mixed $membres
     */
    public function setMembres($membres)
    {
        $this->membres = $membres;
    }

    /**
     * @param mixed $membres
     */
    public function addMembres($membres)
    {
        $this->membres[] = $membres;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomC
     *
     * @param string $nomC
     *
     * @return Club
     */
    public function setNomC($nomC)
    {
        $this->nomC = $nomC;

        return $this;
    }

    /**
     * Get nomC
     *
     * @return string
     */
    public function getNomC()
    {
        return $this->nomC;
    }

    /**
     * Set mailC
     *
     * @param string $mailC
     *
     * @return Club
     */
    public function setMailC($mailC)
    {
        $this->mailC = $mailC;

        return $this;
    }

    /**
     * Get mailC
     *
     * @return string
     */
    public function getMailC()
    {
        return $this->mailC;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Club
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Club
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set descC
     *
     * @param string $descC
     *
     * @return Club
     */
    public function setDescC($descC)
    {
        $this->descC = $descC;

        return $this;
    }

    /**
     * Get descC
     *
     * @return string
     */
    public function getDescC()
    {
        return $this->descC;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



}

