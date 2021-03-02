<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use  Symfony\Component\Validator\Constraints as Assert;


/**
 * Condidats
 *
 * @ORM\Table(name="condidats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CondidatsRepository")
 */
class Condidats
{

    /**
     * @var int
     *
     * @ORM\Column(name="idCondidats", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCondidats;

    /**
     * @var string
     *
     * @ORM\Column(name="1ceDeCandidature", type="string", length=255, nullable = true )
     */
    private $sourceDeCandidature;
    /**
     * @ORM\ManyToMany(targetEntity="Offres")
     * @ORM\JoinTable(name="Offre_Candidat",
     *      joinColumns={@ORM\JoinColumn(name="Categories_id", referencedColumnName="idCondidats")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="offres_id", referencedColumnName="idOffres")}
     *      )
     */
    private $offre;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=255, nullable = true)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=40, nullable = true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=40, nullable = true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="courriel", type="string", length=255, nullable = true)
     */
    private $courriel;

    /**
     * @var string
     *
     * @ORM\Column(name="situationFamiliale", type="string", length=50, nullable = true)
     */
    private $situationFamiliale;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeNaissance", type="date", nullable = true)
     */
    private $dateDeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="villeDeNaissance", type="string", length=255, nullable = true)
     */
    private $villeDeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255, nullable = true)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable = true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=50, nullable = true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable = true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable = true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroDeTelephone", type="string", length=255, nullable = true)
     */
    private $numeroDeTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="disponibilite", type="string", length=30, nullable = true)
     */
    private $disponibilite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeDisponibilite", type="date", nullable = true)
     */
    private $dateDeDisponibilite;

    /**
     * @var string
     * @Assert\File(mimeTypes = {"application/pdf", "application/x-pdf"},
     * mimeTypesMessage = "Please upload a valid PDF")
     * @ORM\Column(name="curriculumVitae", type="string", length=255, nullable = true)
     */
    private $curriculumVitae;

    /**
     * @var string
     * @Assert\File(mimeTypes = {"application/pdf", "application/x-pdf"},
     * mimeTypesMessage = "Please upload a valid PDF")
     * @ORM\Column(name="lettreeMotivation", type="string", length=255, nullable = true)
     */
    private $lettreeMotivation;


    /**
     * Get idCondidats
     *
     * @return int
     */
    public function getIdCondidats()
    {
        return $this->idCondidats;
    }

    /**
     * Set sourceDeCandidature
     *
     * @param string $sourceDeCandidature
     *
     * @return Condidats
     */
    public function setSourceDeCandidature($sourceDeCandidature)
    {
        $this->sourceDeCandidature = $sourceDeCandidature;

        return $this;
    }

    /**
     * Get sourceDeCandidature
     *
     * @return string
     */
    public function getSourceDeCandidature()
    {
        return $this->sourceDeCandidature;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Condidats
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Condidats
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Condidats
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set courriel
     *
     * @param string $courriel
     *
     * @return Condidats
     */
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;

        return $this;
    }

    /**
     * Get courriel
     *
     * @return string
     */
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set situationFamiliale
     *
     * @param string $situationFamiliale
     *
     * @return Condidats
     */
    public function setSituationFamiliale($situationFamiliale)
    {
        $this->situationFamiliale = $situationFamiliale;

        return $this;
    }

    /**
     * Get situationFamiliale
     *
     * @return string
     */
    public function getSituationFamiliale()
    {
        return $this->situationFamiliale;
    }

    /**
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     *
     * @return Condidats
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * Set villeDeNaissance
     *
     * @param string $villeDeNaissance
     *
     * @return Condidats
     */
    public function setVilleDeNaissance($villeDeNaissance)
    {
        $this->villeDeNaissance = $villeDeNaissance;

        return $this;
    }

    /**
     * Get villeDeNaissance
     *
     * @return string
     */
    public function getVilleDeNaissance()
    {
        return $this->villeDeNaissance;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Condidats
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Condidats
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Condidats
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Condidats
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Condidats
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set numeroDeTelephone
     *
     * @param string $numeroDeTelephone
     *
     * @return Condidats
     */
    public function setNumeroDeTelephone($numeroDeTelephone)
    {
        $this->numeroDeTelephone = $numeroDeTelephone;

        return $this;
    }

    /**
     * Get numeroDeTelephone
     *
     * @return string
     */
    public function getNumeroDeTelephone()
    {
        return $this->numeroDeTelephone;
    }

    /**
     * Set disponibilite
     *
     * @param string $disponibilite
     *
     * @return Condidats
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return string
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * Set dateDeDisponibilite
     *
     * @param \DateTime $dateDeDisponibilite
     *
     * @return Condidats
     */
    public function setDateDeDisponibilite($dateDeDisponibilite)
    {
        $this->dateDeDisponibilite = $dateDeDisponibilite;

        return $this;
    }

    /**
     * Get dateDeDisponibilite
     *
     * @return \DateTime
     */
    public function getDateDeDisponibilite()
    {
        return $this->dateDeDisponibilite;
    }

    /**
     * Set curriculumVitae
     *
     * @param string $curriculumVitae
     *
     * @return Condidats
     */
    public function setCurriculumVitae($curriculumVitae)
    {
        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }

    /**
     * Get curriculumVitae
     *
     * @return string
     */
    public function getCurriculumVitae()
    {
        return $this->curriculumVitae;
    }

    /**
     * Set lettreeMotivation
     *
     * @param string $lettreeMotivation
     *
     * @return Condidats
     */
    public function setLettreeMotivation($lettreeMotivation)
    {
        $this->lettreeMotivation = $lettreeMotivation;

        return $this;
    }

    /**
     * Get lettreeMotivation
     *
     * @return string
     */
    public function getLettreeMotivation()
    {
        return $this->lettreeMotivation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->offre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add offre
     *
     * @param \AppBundle\Entity\Offres $offre
     *
     * @return Condidats
     */
    public function addOffre(\AppBundle\Entity\Offres $offre)
    {
        $this->offre[] = $offre;

        return $this;
    }

    /**
     * Remove offre
     *
     * @param \AppBundle\Entity\Offres $offre
     */
    public function removeOffre(\AppBundle\Entity\Offres $offre)
    {
        $this->offre->removeElement($offre);
    }

    /**
     * Get offre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffre()
    {
        return $this->offre;
    }

}
