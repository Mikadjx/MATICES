<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $eventDate = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    // NOUVEAUX CHAMPS
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $isVisible = true;

    #[ORM\Column(options: ['default' => 0])]
    private ?int $position = 0;

    // RELATIONS (optionnelles - décommentez si vous voulez lier photos/videos/songs aux événements)

    // #[ORM\OneToMany(mappedBy: 'event', targetEntity: Photo::class)]
    // private Collection $photos;

    // #[ORM\OneToMany(mappedBy: 'event', targetEntity: Video::class)]
    // private Collection $videos;

    // #[ORM\OneToMany(mappedBy: 'event', targetEntity: Song::class)]
    // private Collection $songs;

    public function __construct()
    {
        // Décommentez si vous utilisez les relations
        // $this->photos = new ArrayCollection();
        // $this->videos = new ArrayCollection();
        // $this->songs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEventDate(): ?\DateTime
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTime $eventDate): static
    {
        $this->eventDate = $eventDate;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;
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

    // NOUVEAUX GETTERS/SETTERS

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;
        return $this;
    }

    // MÉTHODES POUR LES RELATIONS (décommentez si nécessaire)

    // /**
    //  * @return Collection<int, Photo>
    //  */
    // public function getPhotos(): Collection
    // {
    //     return $this->photos;
    // }

    // public function addPhoto(Photo $photo): static
    // {
    //     if (!$this->photos->contains($photo)) {
    //         $this->photos->add($photo);
    //         $photo->setEvent($this);
    //     }
    //     return $this;
    // }

    // public function removePhoto(Photo $photo): static
    // {
    //     if ($this->photos->removeElement($photo)) {
    //         if ($photo->getEvent() === $this) {
    //             $photo->setEvent(null);
    //         }
    //     }
    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Video>
    //  */
    // public function getVideos(): Collection
    // {
    //     return $this->videos;
    // }

    // public function addVideo(Video $video): static
    // {
    //     if (!$this->videos->contains($video)) {
    //         $this->videos->add($video);
    //         $video->setEvent($this);
    //     }
    //     return $this;
    // }

    // public function removeVideo(Video $video): static
    // {
    //     if ($this->videos->removeElement($video)) {
    //         if ($video->getEvent() === $this) {
    //             $video->setEvent(null);
    //         }
    //     }
    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Song>
    //  */
    // public function getSongs(): Collection
    // {
    //     return $this->songs;
    // }

    // public function addSong(Song $song): static
    // {
    //     if (!$this->songs->contains($song)) {
    //         $this->songs->add($song);
    //         $song->setEvent($this);
    //     }
    //     return $this;
    // }

    // public function removeSong(Song $song): static
    // {
    //     if ($this->songs->removeElement($song)) {
    //         if ($song->getEvent() === $this) {
    //             $song->setEvent(null);
    //         }
    //     }
    //     return $this;
    // }

    // Pour l'affichage dans EasyAdmin
    public function __toString(): string
    {
        return $this->name ?? 'Event #' . $this->id;
    }

    // Helper pour la date formatée
    public function getFormattedEventDate(): string
    {
        if (!$this->eventDate) {
            return '';
        }
        
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN
        );
        
        return ucfirst($formatter->format($this->eventDate));
    }
}