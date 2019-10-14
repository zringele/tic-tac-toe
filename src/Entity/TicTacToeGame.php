<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicTacToeGameRepository")
 */
class TicTacToeGame
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="result")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $result;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameMove", mappedBy="game", orphanRemoval=true)
     */
    private $gameMoves;

    public function __construct()
    {
        $this->gameMoves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(?int $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Collection|GameMove[]
     */
    public function getGameMoves(): Collection
    {
        return $this->gameMoves;
    }

    public function addGameMove(GameMove $gameMove): self
    {
        if (!$this->gameMoves->contains($gameMove)) {
            $this->gameMoves[] = $gameMove;
            $gameMove->setGame($this);
        }

        return $this;
    }

    public function removeGameMove(GameMove $gameMove): self
    {
        if ($this->gameMoves->contains($gameMove)) {
            $this->gameMoves->removeElement($gameMove);
            // set the owning side to null (unless already changed)
            if ($gameMove->getGame() === $this) {
                $gameMove->setGame(null);
            }
        }

        return $this;
    }

}
