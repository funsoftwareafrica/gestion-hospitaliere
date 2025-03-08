<?php

namespace App\Entity;

use App\Repository\PersonnelSoignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonnelSoignantRepository::class)]
class PersonnelSoignant // Remove UserInterface and PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La spécialité est obligatoire.")]
    private ?string $specialite = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le téléphone est obligatoire.")]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    private ?string $email = null;

    /**
     * @var Collection<int, Urgence>
     */
    #[ORM\OneToMany(targetEntity: Urgence::class, mappedBy: 'personnelSoignant')]
    private Collection $urgences;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'personnelSoignant')]
    private Collection $notifications;

    #[ORM\Column]
    private ?string $password = null;

    public function __construct()
    {
        $this->urgences = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    // ... (autres méthodes getter et setter)

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // Ajout de la méthode getNom()
    public function getNom(): ?string
    {
        return $this->nom;
    }

    // Ajout de la méthode getPrenom()
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    // Ajout de la méthode getSpecialite()
    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    // Ajout de la méthode getTelephone()
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    // Ajout de la méthode getEmail()
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
