<?php
declare(strict_types = 1);

namespace App\Solver;

abstract class Position
{

    protected function worstMoveScore($action)
    {
        if ($this->isFinalPosition()) {
            return $this->getScore();
        }
        $possiblePosition = $this->positionAfterAction($action);

        $worstScore = 2;
        foreach ($possiblePosition->getAvailableMoves() as $action) {
            $score = $possiblePosition->worstMoveScore($action);
            if ($score === 0) {
                $worstScore = 0;
                break;
            }
        }
        return $worstScore;
    }

    public function bestMove()
    {
        foreach ($this->getAvailableActions() as $move) {}
    }

    abstract function isFinalPosition();

    abstract function getScore();

    abstract function positionAfterAction($move);

    abstract function getAvailableActions();
}
