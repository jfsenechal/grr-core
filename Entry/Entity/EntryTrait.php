<?php

namespace Grr\Core\Entry\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Grr\Core\Contrat\Entity\AreaInterface;
use Grr\Core\Contrat\Entity\EntryInterface;
use Grr\Core\Contrat\Entity\TypeEntryInterface;
use Grr\Core\Doctrine\Traits\IdEntityTrait;
use Grr\Core\Doctrine\Traits\NameEntityTrait;
use Grr\Core\Model\DurationModel;
use Grr\Core\Model\TimeSlot;
use Grr\Core\Periodicity\Entity\PeriodicityFieldTrait;
use Grr\Core\Room\Entity\RoomFieldTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Entry.
 */
trait EntryTrait
{
    use IdEntityTrait;
    use NameEntityTrait;
    use TimestampableTrait;
    use RoomFieldTrait;
    use PeriodicityFieldTrait;

    /**
     * @var DateTimeInterface
     *
     * @Assert\Type("DateTime")
     * @Assert\LessThan(propertyPath="endTime", message="entry.constraint.start_smaller_end")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeInterface $startTime;

    /**
     * @var DateTimeInterface
     * @Assert\Type("DateTime")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTimeInterface $endTime;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $createdBy;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $reservedFor;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", length=65535, nullable=true)
     */
    private ?string $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private ?string $statutEntry;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $optionReservation;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", length=65535, nullable=true)
     */
    private ?string $overloadDesc;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $moderate;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $private;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $jours;

    /**
     * @var TypeEntryInterface|null
     * @ORM\ManyToOne(targetEntity="Grr\Core\Contrat\Entity\TypeEntryInterface", inversedBy="entries")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private ?TypeEntryInterface $type;

    /**
     * Util lors de l'ajout d'un Entry.
     *
     * @var AreaInterface|null
     */
    private ?AreaInterface $area;

    /**
     * @var DurationModel
     */
    private DurationModel $duration;

    /**
     * Pour l'affichage, TimeSlot présents.
     *
     * @var ArrayCollection|TimeSlot[]
     */
    private iterable $locations = [];

    /**
     * Pour l'affichage par jour, nbre de cellules occupees.
     *
     * @var int
     */
    private int $cellules;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->private = false;
        $this->moderate = false;
        $this->jours = false;
        $this->optionReservation = 0;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getCellules(): int
    {
        return $this->cellules;
    }

    /**
     * @return EntryInterface
     */
    public function setCellules(int $cellules): void
    {
        $this->cellules = $cellules;
    }

    public function addLocation(array $location): void
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
        }
    }

    public function getDuration(): ?DurationModel
    {
        return $this->duration;
    }

    /**
     * @return EntryInterface
     */
    public function setDuration(?DurationModel $durationModel): void
    {
        $this->duration = $durationModel;
    }

    public function getArea(): ?AreaInterface
    {
        return $this->area;
    }

    public function setArea(?AreaInterface $area): void
    {
        $this->area = $area;
    }

    /**
     * @return Collection|array|TimeSlot[]
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    public function setLocations(array $locations): void
    {
        $this->locations = $locations;
    }

    public function getStartTime(): ?DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $dateTime): void
    {
        $this->startTime = $dateTime;
    }

    public function getEndTime(): ?DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(DateTimeInterface $dateTime): void
    {
        $this->endTime = $dateTime;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getStatutEntry(): ?string
    {
        return $this->statutEntry;
    }

    public function setStatutEntry(?string $statutEntry): void
    {
        $this->statutEntry = $statutEntry;
    }

    public function getOptionReservation(): int
    {
        return $this->optionReservation;
    }

    public function setOptionReservation(int $optionReservation): void
    {
        $this->optionReservation = $optionReservation;
    }

    public function getOverloadDesc(): ?string
    {
        return $this->overloadDesc;
    }

    public function setOverloadDesc(?string $overloadDesc): void
    {
        $this->overloadDesc = $overloadDesc;
    }

    public function getModerate(): ?bool
    {
        return $this->moderate;
    }

    public function setModerate(?bool $moderate): void
    {
        $this->moderate = $moderate;
    }

    public function getPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    public function getJours(): ?bool
    {
        return $this->jours;
    }

    public function setJours(bool $jours): void
    {
        $this->jours = $jours;
    }

    public function getType(): ?TypeEntryInterface
    {
        return $this->type;
    }

    public function setType(?TypeEntryInterface $typeEntry): void
    {
        $this->type = $typeEntry;
    }

    public function getReservedFor(): ?string
    {
        return $this->reservedFor;
    }

    public function setReservedFor(?string $reservedFor): void
    {
        $this->reservedFor = $reservedFor;
    }
}
