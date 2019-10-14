<?php
declare(strict_types = 1);

namespace App\Solver;


use App\Entity\GameMove;

class TicTacToePosition extends Position
{

    const ALL_POSSIBLE_ACTIONS = [
        1,2,3,4,5,6,7,8,9
    ];

    /**
     * @var array holds all moves made in this position
     */
    protected $moves = [];

    /**
     * @var int determines which turn was made last
     */
    protected $lastTurn = 0;

    /**
     * @var array all actions made
     */
    protected $actionsMade = [];

    /**
     * @var int determines the score of position
     */
    protected $score = 1;

    protected $isFinal;

    /**
     * @var array determines actions made by X player
     */
    protected $xActions = [];

    /**
     * @var array determines actions made by Y player
     */
    protected $yActions = [];

    public function __construct( array $moves )
    {
        $this->moves = $moves;
        foreach ($moves as $move) {
            $this->actionsMade[] = $move->getAction();
            $this->lastTurn = $move->getTurn() > $this->lastTurn ? $move->getTurn() : $this->lastTurn;

            if ($move->getMadeBy() === 1) {
                $this->xActions[] = $move->getAction();
            } else {
                $this->yActions[] = $move->getAction();
            }
        }

        $this->checkScore();
    }

    /**
     * @return string
     * Generates text message based on result
     */
    public function generateMessage(): string
    {
        switch ($this->getScore()) {
            case 2:
                return 'You lost! better luck next time!';
            case 1:
                return 'You got lucky! It`s a draw';
            case 0:
                return 'You definitely cheated your way here';
            default:
                return 'Beep BOOP error not expected';
        }
    }

    /**
     * updates score
     */
    public function checkScore(): void
    {
        if ($this->hasWinner($this->xActions)) {
            $this->score = 0;
        }

        if ($this->hasWinner($this->yActions)) {
            $this->score = 2;
        }
    }

    /**
     * @param array $array
     * @return bool
     * checks if array of taken places has a winner
     */
    public function hasWinner( array $array ): bool
    {
        if ( $this->intersects($array, [1,2,3])
            || $this->intersects($array, [4,5,6])
            || $this->intersects($array, [7,8,9])
            || $this->intersects($array, [1,4,7])
            || $this->intersects($array, [2,5,8])
            || $this->intersects($array, [3,6,9])
            || $this->intersects($array, [1,5,9])
            || $this->intersects($array, [7,5,3])
        ){
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @return bool
     */
    public function aiTurn(): bool
    {
        return ($this->lastTurn % 2 !== 0);
    }
    /**
     * @return bool
     * game is over if we know the winner, or all possible actions are made
     */
    public function isFinalPosition(): bool
    {
        return (($this->score !== 1) || (count($this->moves) >= count(self::ALL_POSSIBLE_ACTIONS)));
    }

    /**
     * @param $action
     * @return TicTacToePosition
     */
    public function positionAfterAction($action): Position
    {
        $newMove = new GameMove();
        $newMove->setAction($action);
        $newMove->setTurn($this->lastTurn + 1);
        $moves = $this->moves;
        $moves[] = $newMove;

        return new TicTacToePosition($moves);
    }

    public function getAvailableActions(): ?array
    {
        return array_diff(self::ALL_POSSIBLE_ACTIONS, $this->actionsMade);
    }

    /**
     * @param array $array
     * @return bool
     */
    protected function intersects(array $array, array $array2 ): bool
    {
        return count(array_intersect($array, $array2)) === 3;
    }
}