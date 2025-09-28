<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
#[Assert\Callback('validateDependentFields')]

class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $photoType = null; // "avant" ou "apres"

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $nettoyageNumber = null;

    public const TYPES = ['photo', 'video'];
    public const CATEGORIES = [
    'Intérieur',
    'Extérieur',
    'Véhicules spéciaux',
    'Nettoyage complet',
];

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: self::TYPES, message: "Type invalide.")]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $imageFilename = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(length: 100)]
    private ?string $category = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

     public function validateDependentFields(ExecutionContextInterface $context): void
    {
        // Si l'un des deux est rempli, l'autre doit l'être aussi
        if (($this->nettoyageNumber && !$this->photoType) || (!$this->nettoyageNumber && $this->photoType)) {
            $context->buildViolation('Si vous choisissez une "Réalisation", vous devez aussi choisir un "Type de photo" et inversement.')
                ->atPath('nettoyageNumber')
                ->addViolation();

            $context->buildViolation('Si vous choisissez un "Type de photo", vous devez aussi choisir une "Réalisation" et inversement.')
                ->atPath('photoType')
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

     public function getNettoyageNumber(): ?int
    {
        return $this->nettoyageNumber;
    }

    public function setNettoyageNumber(?int $nettoyageNumber): static
    {
        $this->nettoyageNumber = $nettoyageNumber;
        return $this;
    }

  
    public function getPhotoType(): ?string
    {
        return $this->photoType;
    }

    public function setPhotoType(?string $photoType): static
    {
        $this->photoType = $photoType;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(string $imageFilename): static
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }


    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}
