<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $youtubeId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $eventName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $eventDate = null;

    #[ORM\Column(options: ['default' => 0])]
    private ?int $position = 0;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $isVisible = true;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getYoutubeId(): ?string { return $this->youtubeId; }
    public function setYoutubeId(string $youtubeId): static { $this->youtubeId = $youtubeId; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): static { $this->createdAt = $createdAt; return $this; }

    public function getEventName(): ?string { return $this->eventName; }
    public function setEventName(?string $eventName): static { $this->eventName = $eventName; return $this; }

    public function getEventDate(): ?\DateTime { return $this->eventDate; }
    public function setEventDate(?\DateTime $eventDate): static { $this->eventDate = $eventDate; return $this; }

    public function getPosition(): ?int { return $this->position; }
    public function setPosition(int $position): static { $this->position = $position; return $this; }

    public function isVisible(): ?bool { return $this->isVisible; }
    public function setIsVisible(bool $isVisible): static { $this->isVisible = $isVisible; return $this; }

    public function __toString(): string { return $this->title ?? 'Video #' . $this->id; }

    public function getYoutubeUrl(): string
    {
        return 'https://www.youtube.com/watch?v=' . $this->youtubeId;
    }

    public function getYoutubeThumbnailUrl(string $quality = 'maxresdefault'): string
    {
        return "https://img.youtube.com/vi/{$this->youtubeId}/{$quality}.jpg";
    }

    public function getYoutubeEmbedUrl(): string
    {
        return "https://www.youtube.com/embed/{$this->youtubeId}";
    }

    public function getFormattedEventDate(): string
    {
        $date = $this->eventDate ?? $this->createdAt;
        if (!$date) return '';
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN,
            'MMMM yyyy'
        );
        return ucfirst($formatter->format($date));
    }
}