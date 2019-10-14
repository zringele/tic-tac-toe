<?php
declare(strict_types = 1);

namespace App\Solver;

abstract class Position
{

    /**
     * @return int
     *
     * Evaluates position score
     * https://en.wikipedia.org/wiki/Minimax
     */
    public function minimax(): int
    {
        if($this->isFinalPosition()) {
            return $this->getScore();
        }

        $scores = [];
        foreach ($this->getAvailableActions() as $possibleAction) {
            $possiblePosition = $this->positionAfterAction($possibleAction);
            $scores[] = $possiblePosition->minimax();
        }

        if ($this->aiTurn()) {
            return max($scores);
        } else {
            return min($scores);
        }
    }

    /**
     * @return int
     *
     * returns best possible move
     */
    public function bestMove(): int
    {
        $bestMove = 0;
        $bestAction = current($this->getAvailableActions());
        foreach ($this->getAvailableActions() as $possibleAction) {
            $possiblePosition = $this->positionAfterAction($possibleAction);
            $move = $possiblePosition->minimax();
            if ($move > $bestMove) {
                $bestMove = $move;
                $bestAction = $possibleAction;
            }
        }
        return $bestAction;
    }

    /**
     * Required methods for game solving
     */

    abstract function isFinalPosition(): bool;

    abstract function aiTurn(): bool;

    abstract function getScore(): int;

    abstract function positionAfterAction($move): Position;

    abstract function getAvailableActions(): ?array;
}
