<?php
declare(strict_types = 1);


namespace App\Controller;


use App\Entity\GameMove;
use App\Entity\TicTacToeGame;
use App\Solver\TicTacToePosition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/", name="play")
     */
    public function play(): Response
    {
        return $this->render('game/play.html.twig');
    }

    /**
     * @Route("/game/new", name="new-game")
     */
    public function new(): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ticTacToeGame = new TicTacToeGame();

        $entityManager->persist($ticTacToeGame);
        $entityManager->flush();
        return new JsonResponse(['game' => $ticTacToeGame->getId()]);
    }
    /**
     * @param int $gameId
     * @param int $action
     * @Route("/game/{gameId}/move/{action}")
     * @return JsonResponse
     */
    public function getResponse(int $gameId, int $action): JsonResponse
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $gameMoveRepo = $doctrine->getRepository(GameMove::class);
        $game = $doctrine->getRepository(TicTacToeGame::class)->find($gameId);

        $moves = $gameMoveRepo
            ->findByGame($game);

        $gameMove = new GameMove();
        $gameMove->setGame($game);
        $gameMove->setAction($action);

        // We ordered by turn DESC, so we trust it`s highest turn we got
        $lastTurn = isset($moves[0]) ? $moves[0]->getTurn() : 0;
        $gameMove->setTurn($lastTurn+1);

        $entityManager->persist($gameMove);

        $moves[] = $gameMove;
        $position = new TicTacToePosition( $moves );
        if ($position->isFinalPosition()) {
            return new JsonResponse([
                'response' => 0,
                'playing' => 0,
                'message' => $position->generateMessage()
            ]);
        }

            $response = $position->bestMove();

        $position = $position->positionAfterAction($response);

        if ($position->isFinalPosition()) {
            return new JsonResponse([
                'response' => $response,
                'playing' => 0,
                'message' => $position->generateMessage()
            ]);
        }

        $gameMove = new GameMove();
        $gameMove->setGame($game);
        $gameMove->setAction($response);
        $gameMove->setTurn($lastTurn+2);
        $entityManager->persist($gameMove);

        $entityManager->flush();

        return new JsonResponse([
            'response' => $response,
            'playing' => 1,
            'message' => 'Your turn'
        ]);
    }

}