<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameMoveRepository")
 */
class GameMove
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TicTacToeGame", inversedBy="gameMoves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="smallint")
     */
    private $turn;

    /**
     * @ORM\Column(type="smallint")
     */
    private $action;

    private $madeBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?TicTacToeGame
    {
        return $this->game;
    }

    public function setGame(?TicTacToeGame $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(int $turn): self
    {
        $this->turn = $turn;

        return $this;
    }

    public function getAction(): ?int
    {
        return $this->action;
    }

    public function setAction(int $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * determines who made the move. 1 is X, 2 is Y
     */
    public function getMadeBy(): int
    {
        return $this->getTurn() % 2 === 0 ? 2 : 1;
    }
}
