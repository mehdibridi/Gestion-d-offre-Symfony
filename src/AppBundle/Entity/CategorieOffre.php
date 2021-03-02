<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieOffre
 *
 * @ORM\Table(name="categorieOffre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieOffreRepository")
 */
class CategorieOffre
{

    /**
     * @var int
     *
     * @ORM\Column(name="idCategorieOffre", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCategorieOffre;
    /**
     * @ORM\OneToOne(targetEntity="Offres", mappedBy="categorieOffre",cascade={"remove"})
     */
    private $offre;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable = true)
     */
    private $categorie;


    /**
     * Get id
     *
     * @return int
     */
    public function getIdCategorieOffre()
    {
        return $this->idCategorieOffre;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return CategorieOffre
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }





    /**
     * Set offre
     *
     * @param \AppBundle\Entity\Offres $offre
     *
     * @return CategorieOffre
     */
    public function setOffre(\AppBundle\Entity\Offres $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \AppBundle\Entity\Offres
     */
    public function getOffre()
    {
        return $this->offre;
    }

}
