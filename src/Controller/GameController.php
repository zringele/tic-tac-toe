<?php
declare(strict_types = 1);


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/", name="play")
     */
    public function play()
    {
        return $this->render('game/play.html.twig');
    }

    /**
     * @Route("/", name="play")
     */
    public function play()
    {
        return $this->render('game/play.html.twig');
    }
    /**
     * @param int $game
     * @param int $move
     * @Route("/game/{game}/move/{move}")
     * @return JsonResponse
     */
    public function getResponse(int $game, int $move)
    {
        return new JsonResponse(['name' => $game, 'move' => $move]);
    }

}