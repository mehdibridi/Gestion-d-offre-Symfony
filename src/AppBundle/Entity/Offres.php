<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use  Symfony\Component\Validator\Constraints as Assert;
/**
 * Offres
 *
 * @ORM\Table(name="offres")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OffresRepository")

 */
// @UniqueEntity("categorieOffre")

class Offres
{

    /**
     * @var int
     *
     * @ORM\Column(name="idOffres", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idOffres;

    /**
     * @ORM\ManyToMany(targetEntity="Condidats", mappedBy="offre")
     */
    private $condidat;
    /**
     * @ORM\OneToOne(targetEntity="CategorieOffre", inversedBy="offre")
     * @ORM\JoinColumn(name="CategorieOffre_id", referencedColumnName="idCategorieOffre", onDelete="CASCADE")
     * @Assert\NotBlank(message="Champ deja existant")
     */

    private $categorieOffre;


    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable = true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="datePostulation", type="datetime", length=255, nullable = true)
     */
    private $datePostulation;

    /**
     * @var string
     *
     * @ORM\Column(name="activite", type="string", length=5000, nullable = true)
     */
    private $activite;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="string", length=5000, nullable = true)
     */
    private $qualification;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="string", length=5000, nullable = true)
     */
    private $competence;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=5000, nullable = true)
     */
    private $description;

    /**
     * Get idOffres
     *
     * @return int
     */
    public function getIdOffres()
    {
        return $this->idOffres;
    }


    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Offres
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set datePostulation
     *
     * @param string $datePostulation
     *
     * @return Offres
     */
    public function setDatePostulation($datePostulation)
    {
        $this->datePostulation = $datePostulation;

        return $this;
    }

    /**
     * Get datePostulation
     *
     * @return string
     */
    public function getDatePostulation()
    {
        return $this->datePostulation;
    }

    /**
     * Set activite
     *
     * @param string $activite
     *
     * @return Offres
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get ativite
     *
     * @return string
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return Offres
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set competence
     *
     * @param string $competence
     *
     * @return Offres
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offres
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->condidat = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add condidat
     *
     * @param \AppBundle\Entity\Condidats $condidat
     *
     * @return Offres
     */
    public function addCondidat(\AppBundle\Entity\Condidats $condidat)
    {
        $this->condidat[] = $condidat;

        return $this;
    }

    /**
     * Remove condidat
     *
     * @param \AppBundle\Entity\Condidats $condidat
     */
    public function removeCondidat(\AppBundle\Entity\Condidats $condidat)
    {
        $this->condidat->removeElement($condidat);
    }

    /**
     * Get condidat
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCondidat()
    {
        return $this->condidat;
    }




    /**
     * Set categorieOffre
     *
     * @param \AppBundle\Entity\CategorieOffre $categorieOffre
     *
     * @return Offres
     */
    public function setCategorieOffre(\AppBundle\Entity\CategorieOffre $categorieOffre = null)
    {
        $this->categorieOffre = $categorieOffre;

        return $this;
    }

    /**
     * Get categorieOffre
     *
     * @return \AppBundle\Entity\CategorieOffre
     */
    public function getCategorieOffre()
    {
        return $this->categorieOffre;
    }

}
