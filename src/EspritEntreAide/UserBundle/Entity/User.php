<?php


namespace EspritEntreAide\UserBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="EspritEntreAide\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom ;


    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom ;

    /**
     * @ORM\OneToOne(targetEntity="EspritEntreAide\StoreBundle\Entity\Store",mappedBy="user")
     */
    private $store;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToMany(targetEntity="EspritEntreAide\ClubBundle\Entity\Club", mappedBy="membres")
     */
    private $clubs;

    /**
     * @return mixed
     */
    public function getClubs()
    {
        return $this->clubs;
    }

    /**
     * @param mixed $clubs
     */
    public function setClubs($clubs)
    {
        $this->clubs = $clubs;
    }

    /**
     * @ORM\ManyToMany(targetEntity="EspritEntreAide\EvenementBundle\Entity\Evenement", mappedBy="participants")
     */
    private $participations;

    /**
     * @return mixed
     */
    public function getParticipations()
    {
        return $this->participations;
    }

    /**
     * @param mixed $participations
     */
    public function setParticipations($participations)
    {
        $this->participations = $participations;
    }


    /**
     * @ORM\OneToMany(targetEntity="EspritEntreAide\EvenementBundle\Entity\Evenement", mappedBy="idUser")
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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function __construct()
    {
        parent::__construct(); // your own logic

    }

}

