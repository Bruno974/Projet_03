<?php

namespace GB\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="calendrier", type="datetimetz")
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
     */
    private $mail;


    public function __construct()
    {
        $this->calendrier = new \DateTime();
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
}

