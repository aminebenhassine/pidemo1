<?php

namespace EspritEntreAide\SpottedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="EspritEntreAide\SpottedBundle\Repository\PublicationRepository")
 */
class Publication
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
     * @ORM\Column(name="titre_p", type="string", length=255, nullable=true)
     */
    private $titreP;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_p", type="text", nullable=true)
     */
    private $descP;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank (message="Ajouter une image png")
     * @Assert\File(mimeTypes={ "image/png" })
     */
    private $image;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_p", type="date", nullable=true)
     */
    private $dateP;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_p", type="string", length=255, nullable=true)
     */
    private $categorieP;

    /**
     * @ORM\ManyToOne(targetEntity="EspritEntreAide\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    public $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\OneToMany(targetEntity="EspritEntreAide\SpottedBundle\Entity\Commentaire", mappedBy="idPublication")
     *
     */
    private $commentaires;

    /**
     * @return mixed
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param mixed $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modif", type="date", nullable=true)
     */
    private $dateModif;


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
     * Set titreP
     *
     * @param string $titreP
     *
     * @return Publication
     */
    public function setTitreP($titreP)
    {
        $this->titreP = $titreP;

        return $this;
    }

    /**
     * Get titreP
     *
     * @return string
     */
    public function getTitreP()
    {
        return $this->titreP;
    }

    /**
     * Set descP
     *
     * @param string $descP
     *
     * @return Publication
     */
    public function setDescP($descP)
    {
        $this->descP = $descP;

        return $this;
    }

    /**
     * Get descP
     *
     * @return string
     */
    public function getDescP()
    {
        return $this->descP;
    }

    /**
     * Set dateP
     *
     * @param \DateTime $dateP
     *
     * @return Publication
     */
    public function setDateP($dateP)
    {
        $this->dateP = $dateP;

        return $this;
    }

    /**
     * Get dateP
     *
     * @return \DateTime
     */
    public function getDateP()
    {
        return $this->dateP;
    }

    /**
     * Set categorieP
     *
     * @param string $categorieP
     *
     * @return Publication
     */
    public function setCategorieP($categorieP)
    {
        $this->categorieP = $categorieP;

        return $this;
    }

    /**
     * Get categorieP
     *
     * @return string
     */
    public function getCategorieP()
    {
        return $this->categorieP;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Publication
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
     * Set note
     *
     * @param integer $note
     *
     * @return Publication
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Publication
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

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

