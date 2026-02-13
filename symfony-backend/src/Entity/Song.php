<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[Vich\Uploadable]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $artist = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    // Nouveau : Chemin du fichier audio stocké en BDD
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePath = null;

    // Nouveau : Fichier uploadé (non persisté en BDD)
    #[Vich\UploadableField(mapping: 'music_files', fileNameProperty: 'filePath')]
    private ?File $musicFile = null;

    // Nouveau : Durée de la chanson en secondes
    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    // Nouveau : Position dans la playlist (pour l'ordre d'affichage)
    #[ORM\Column(options: ['default' => 0])]
    private ?int $position = 0;

    // Nouveau : Visibilité sur le site public
    #[ORM\Column(options: ['default' => true])]
    private ?bool $isVisible = true;

    // Nouveau : Date de mise à jour (pour VichUploader)
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

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

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): static
    {
        $this->artist = $artist;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    // Nouveaux getters/setters pour les champs ajoutés

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getMusicFile(): ?File
    {
        return $this->musicFile;
    }

    public function setMusicFile(?File $musicFile = null): void
    {
        $this->musicFile = $musicFile;

        if (null !== $musicFile) {
            // Mettre à jour updatedAt pour forcer Doctrine à persister
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    // Pour l'affichage dans EasyAdmin
    public function __toString(): string
    {
        return $this->title . ' - ' . $this->artist;
    }

    // Méthode helper pour obtenir la durée formatée
    public function getFormattedDuration(): string
    {
        if (!$this->duration) {
            return '--:--';
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}