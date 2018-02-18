<?php

namespace EspritEntreAide\AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="EspritEntreAide\AnnonceBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @ORM\Column(name="titre_a", type="string", length=255, nullable=true)
     */
    private $titreA;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_a", type="text", nullable=true)
     */
    private $descA;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_a", type="date", nullable=true)
     */
    private $dateA;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_a", type="string", length=255, nullable=true)
     */
    private $categorieA;

    /**
     * @ORM\ManyToOne(targetEntity="EspritEntreAide\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="num_tel", type="integer", nullable=true)
     */
    private $numTel;

    /**
     * @var int
     *
     * @ORM\Column(name="id_rep", type="integer", nullable=true)
     */
    private $idRep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="date", nullable=true)
     */
    private $dateModif;

    /**
     * @ORM\OneToMany(targetEntity="EspritEntreAide\StoreBundle\Entity\Document", mappedBy="id_annonce")
     *
     */
    private $documents;







    /**************************************************************************************************/




    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param mixed $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
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
     * Set titreA
     *
     * @param string $titreA
     *
     * @return Annonce
     */
    public function setTitreA($titreA)
    {
        $this->titreA = $titreA;

        return $this;
    }

    /**
     * Get titreA
     *
     * @return string
     */
    public function getTitreA()
    {
        return $this->titreA;
    }

    /**
     * Set descA
     *
     * @param string $descA
     *
     * @return Annonce
     */
    public function setDescA($descA)
    {
        $this->descA = $descA;

        return $this;
    }




    /**
     * Get descA
     *
     * @return string
     */
    public function getDescA()
    {
        return $this->descA;
    }

    /**
     * Set dateA
     *
     * @param \DateTime $dateA
     *
     * @return Annonce
     */
    public function setDateA()
    {
        $this->dateA = new \DateTime();

        return $this;
    }

    /**
     * @return string
     */
    public function getCategorieA()
    {
        return $this->categorieA;
    }

    /**
     * @param string $categorieA
     */
    public function setCategorieA($categorieA)
    {
        $this->categorieA = $categorieA;
    }


    /**
     * Get dateA
     *
     * @return \DateTime
     */
    public function getDateA()
    {
        return $this->dateA;
    }


    /**
     * Set numTel
     *
     * @param integer $numTel
     *
     * @return Annonce
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;

        return $this;
    }

    /**
     * Get numTel
     *
     * @return int
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdRep()
    {
        return $this->idRep;
    }

    /**
     * @param int $idRep
     */
    public function setIdRep($idRep)
    {
        $this->idRep = $idRep;
    }



    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Annonce
     */
    public function setDateModif()
    {
        $this->dateModif = new \DateTime();

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }







}

