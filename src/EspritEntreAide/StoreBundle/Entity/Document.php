<?php

namespace EspritEntreAide\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Document
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="EspritEntreAide\StoreBundle\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\Column(name="nom_doc", type="string", length=255, nullable=true)
     */
    private $nomDoc;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_doc", type="string", length=255, nullable=true)
     */
    private $etatDoc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upload", type="date", nullable=true)
     */
    private $dateUpload;

    /**
     * @ORM\ManyToOne(targetEntity="EspritEntreAide\AnnonceBundle\Entity\Annonce", inversedBy="documents")
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_annonce;

    /**
     * @ORM\ManyToMany(targetEntity="EspritEntreAide\StoreBundle\Entity\Demande",mappedBy="document")
     */
    private $demande;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

    /**
     * @Assert\File(maxSize="600000000")
     */
    public $fileFile;

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFileFile()
    {
        return $this->fileFile;
    }

    /**
     * @param mixed $fileFile
     */
    public function setFileFile($fileFile)
    {
        $this->fileFile = $fileFile;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadfileFile() {
        if (null !== $this->fileFile) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->file = $filename . '.' . $this->fileFile->guessExtension();
        }
    }

    public function setFilefileFile(UploadedFile $file = null)
    {
        $this->fileFile = $file;
        // check if we have an old file file
        if (isset($this->file)) {
            // store the old name to delete after the update
            $this->temp = $this->file;
            $this->file = null;
        } else {
            $this->file = 'initial';
        }
    }

    /**
     * @ORM\postPersist()
     * @ORM\postUpdate()
     */
    public function uploadfileFile()
    {
        if (null === $this->fileFile)
        {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->fileFile->move($this->getUploadRootDirfileFile(), $this->file);

        unset($this->fileFile);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUploadfileFile()
    {
        if(file_exists($this->getAbsolutefileFile())) {
            if ($this->getUploadRootDirfileFile() . $this->file = $this->getfile()) {
                unlink($this->file);
            }
        }

    }

    public function getAbsolutefileFile()
    {
        return null === $this->file ? null : $this->getUploadRootDirfileFile().'/'.$this->file;
    }

    public function getWebfileFile()
    {
        return null === $this->file ? null : $this->getUploadDirfileFile().'/'.$this->id.'/'.$this->file;
    }

    public function getUploadRootDirfileFile()
    {
        // the absolute directory file where uploaded documents should be saved
        return '../web/'.$this->getUploadDirfileFile().'/'.$this->id;
    }

    public function getUploadDirfileFile()
    {
        // get rid of the _DIR_ so it doesn't screw when displaying uploaded doc/file in the view.
        return 'uploads/catalogue/images';

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
     * Set nomDoc
     *
     * @param string $nomDoc
     *
     * @return Document
     */
    public function setNomDoc($nomDoc)
    {
        $this->nomDoc = $nomDoc;

        return $this;
    }

    /**
     * Get nomDoc
     *
     * @return string
     */
    public function getNomDoc()
    {
        return $this->nomDoc;
    }

    /**
     * @return mixed
     */
    public function getIdAnnonce()
    {
        return $this->id_annonce;
    }

    /**
     * @param mixed $id_annonce
     */
    public function setIdAnnonce($id_annonce)
    {
        $this->id_annonce = $id_annonce;
    }


    /**
     * Set source
     *
     * @param string $source
     *
     * @return Document
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set etatDoc
     *
     * @param string $etatDoc
     *
     * @return Document
     */
    public function setEtatDoc($etatDoc)
    {
        $this->etatDoc = $etatDoc;

        return $this;
    }

    /**
     * Get etatDoc
     *
     * @return string
     */
    public function getEtatDoc()
    {
        return $this->etatDoc;
    }

    /**
     * Set dateUpload
     *
     * @param \DateTime $dateUpload
     *
     * @return Document
     */
    public function setDateUpload($dateUpload)
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    /**
     * Get dateUpload
     *
     * @return \DateTime
     */
    public function getDateUpload()
    {
        return $this->dateUpload;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->demande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add demande
     *
     * @param \EspritEntreAide\StoreBundle\Entity\Demande $demande
     *
     * @return Document
     */
    public function addDemande(\EspritEntreAide\StoreBundle\Entity\Demande $demande)
    {
        $this->demande[] = $demande;
    
        return $this;
    }

    /**
     * Remove demande
     *
     * @param \EspritEntreAide\StoreBundle\Entity\Demande $demande
     */
    public function removeDemande(\EspritEntreAide\StoreBundle\Entity\Demande $demande)
    {
        $this->demande->removeElement($demande);
    }

    /**
     * Get demande
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemande()
    {
        return $this->demande;
    }
}
