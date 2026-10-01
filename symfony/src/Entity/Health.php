<?php

namespace App\Entity;

use App\Repository\HealthRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HealthRepository::class)]
class Health
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $reminderDate = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $practitioner = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentary = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Horse $horse = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'RESTRICT')]
    private ?HealthType $healthType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getReminderDate(): ?\DateTime
    {
        return $this->reminderDate;
    }

    public function setReminderDate(?\DateTime $reminderDate): static
    {
        $this->reminderDate = $reminderDate;

        return $this;
    }

    public function getPractitioner(): ?string
    {
        return $this->practitioner;
    }

    public function setPractitioner(?string $practitioner): static
    {
        $this->practitioner = $practitioner;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): static
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getHorse(): ?Horse
    {
        return $this->horse;
    }

    public function setHorse(?Horse $horse): static
    {
        $this->horse = $horse;

        return $this;
    }

    public function getHealthType(): ?HealthType
    {
        return $this->healthType;
    }

    public function setHealthType(?HealthType $healthType): static
    {
        $this->healthType = $healthType;

        return $this;
    }
}
