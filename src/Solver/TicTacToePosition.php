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
    }


    public function getScore()
    {

    }

    /**
     * @return bool
     * game is over if we know the winner, or all possible actions are made
     */
    public function isFinalPosition()
    {
        return ($this->score !== 1 || count($this->moves) >= count(self::ALL_POSSIBLE_ACTIONS));
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

        return new self($moves);
    }

    public function getAvailableActions()
    {
        return array_diff(self::ALL_POSSIBLE_ACTIONS, $this->actionsMade);
    }
}