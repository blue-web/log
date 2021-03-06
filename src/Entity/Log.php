<?php

namespace BlueWeb\Log\Entity;

use BlueWeb\Log\Repository\LogRepository;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Log
{

    public const LOG_ACTION_CREATED = 'INSERT';
    public const LOG_ACTION_UPDATE = 'UPDATE';
    public const LOG_ACTION_REMOVE = 'DELETE';
    public const LOG_ACTION_IMPORT = 'IMPORT';
    public const LOG_ACTION_GET = 'GET';
    public const LOG_ACTION_INFO = 'INFO';
    public const LOG_ACTION_ERROR = 'ERROR';
    public const LOG_ACTION_SUCCESS = 'SUCCESS';
    public const LOG_ACTION_UPLOAD = 'UPLOAD';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nominative;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $activityName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $action;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $data = [];

    /**
     * @var DateTimeInterface
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $codeGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @return void
     */
    public function onPrePersist(): void
    {
        $this->created = Carbon::now();
    }

    public function getNominative(): ?string
    {
        return $this->nominative;
    }

    public function setNominative(?string $nominative): self
    {
        $this->nominative = $nominative;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getActivityName(): ?string
    {
        return $this->activityName;
    }

    public function setActivityName(?string $activityName): self
    {
        $this->activityName = $activityName;

        return $this;
    }

    public function getCodeGroup(): ?string
    {
        return $this->codeGroup;
    }

    public function setCodeGroup(?string $codeGroup): self
    {
        $this->codeGroup = $codeGroup;

        return $this;
    }

}
