<?php

namespace GB\LouvreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Formulaire
 *
 * @ORM\Table(name="formulaire")
 * @ORM\Entity(repositoryClass="GB\LouvreBundle\Repository\FormulaireRepository")
 */
class Formulaire
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
     *
     * @ORM\Column(name="calendrier", type="date")
     */
    private $calendrier;

    /**
     * @var bool
     *
     * @ORM\Column(name="duree", type="boolean")
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
     */
    private $mail;

    /**
     * @ORM\Column(name="total", type="integer")
     */
    private $total = 0;


    /**
     * @ORM\OneToMany(targetEntity="GB\LouvreBundle\Entity\Visiteur", mappedBy="formulaire", cascade={"persist"})
     *  @Assert\Valid()
     */
    private $visiteurs;


    public function __construct()
    {
        //$this->calendrier = new \DateTime();
        $this->visiteurs = new ArrayCollection();
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
     * Set duree
     *
     * @param boolean $duree
     *
     * @return Formulaire
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return bool
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Formulaire
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Add visiteur
     *
     * @param \GB\LouvreBundle\Entity\Visiteur $visiteur
     *
     * @return Formulaire
     */
    public function addVisiteur(\GB\LouvreBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs[] = $visiteur;
        $visiteur->setFormulaire($this);//lie formulaire aux visiteur

        return $this;
    }

    /**
     * Remove visiteur
     *
     * @param \GB\LouvreBundle\Entity\Visiteur $visiteur
     */
    public function removeVisiteur(\GB\LouvreBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs->removeElement($visiteur);
    }

    /**
     * Get visiteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisiteurs()
    {
        return $this->visiteurs;
    }

    /**
     * Set total
     *
     * @param integer $total
     *
     * @return Formulaire
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /*-----Fonction pour calculer le total du prix des billets--------------------------*/
     public function calculTotal($prix)
    {
        $this->total += $prix;

        return $this;
    }

    

    /**
     * Set calendrier
     *
     * @param \DateTime $calendrier
     *
     * @return Formulaire
     */
    public function setCalendrier($calendrier)
    {
        $this->calendrier = $calendrier;

        return $this;
    }

    /**
     * Get calendrier
     *
     * @return \DateTime
     */
    public function getCalendrier()
    {
        return $this->calendrier;
    }
}
