<?php

namespace Grr\Core\Entity\Security;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Grr\Core\Doctrine\Traits\IdEntityTrait;
use Grr\Core\Doctrine\Traits\TimestampableEntityTrait;
use Grr\Core\Entity\AreaInterface;
use Grr\Core\Entity\RoomInterface;
use Grr\Core\Entity\Security\UserInterface;

/**
 * ORM\Table(name="authorization", uniqueConstraints={
 * @ORM\UniqueConstraint(columns={"user_id", "area_id"}),
 * @ORM\UniqueConstraint(columns={"user_id", "room_id"})
 * })
 * ORM\Entity(repositoryClass="App\Repository\Security\AuthorizationRepository")
 * UniqueEntity(fields={"user", "area"}, message="Ce user est déjà lié au domaine")
 * UniqueEntity(fields={"user", "room"}, message="Ce user est déjà lié à la room")
 */
trait AuthorizationTrait
{
    use IdEntityTrait;
    use TimestampableEntityTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Grr\Core\Entity\Security\UserInterface", inversedBy="authorizations")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var UserInterface
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Grr\Core\Entity\AreaInterface", inversedBy="authorizations")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var AreaInterface|null
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="Grr\Core\Entity\RoomInterface", inversedBy="authorizations")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var RoomInterface|null
     */
    private $room;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isAreaAdministrator;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isResourceAdministrator;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->isAreaAdministrator = false;
        $this->isResourceAdministrator = false;
    }

    public function __toString(): string
    {
        return '';
    }

    public function getIsAreaAdministrator(): ?bool
    {
        return $this->isAreaAdministrator;
    }

    public function setIsAreaAdministrator(bool $isAreaAdministrator): self
    {
        $this->isAreaAdministrator = $isAreaAdministrator;

        return $this;
    }

    public function getIsResourceAdministrator(): ?bool
    {
        return $this->isResourceAdministrator;
    }

    public function setIsResourceAdministrator(bool $isResourceAdministrator): self
    {
        $this->isResourceAdministrator = $isResourceAdministrator;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArea(): ?AreaInterface
    {
        return $this->area;
    }

    public function setArea(?AreaInterface $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getRoom(): ?RoomInterface
    {
        return $this->room;
    }

    public function setRoom(?RoomInterface $room): self
    {
        $this->room = $room;

        return $this;
    }
}
