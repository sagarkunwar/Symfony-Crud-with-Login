<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tasktype;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dueDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserID(): ?User
    {
        return $this->userid;
    }

    public function setUserID(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getTasktype(): ?string
    {
        return $this->tasktype;
    }

    public function setTasktype(string $tasktype): self
    {
        $this->tasktype = $tasktype;

        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }
}
