<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends Controller
{
    /** @var TwitchApiWrapper */
    private $twitchApiWrapper;

    public function __construct(TwitchApiWrapper $twitchApiWrapper)
    {
        $this->twitchApiWrapper = $twitchApiWrapper;
    }

    /**
     * @Route("/stream", name="stream")
     */
    public function index(): Response
    {
        return $this->render('stream/index.html.twig', [
            'nav'  => 'stream',
            'user' => '',
        ]);
    }

    /**
     * @Route("/stream/check", name="stream_check")
     */
    public function check(Request $request): Response
    {
        $name = $request->get('user', '');

        try {
            $user = $this->twitchApiWrapper->getUserByName($name);
            $channelId = $user->getId();
        } catch (UserNotExistsException $e) {
            $channelId = (int)$name;
        }

        $stream = $this->twitchApiWrapper->getStream($channelId);

        return $this->render('stream/stream.html.twig', [
            'nav'    => 'stream',
            'user'   => $stream ? $stream->getChannel()->getName() : $name,
            'stream' => $stream ? $stream->jsonSerialize() : null,
        ]);
    }
}
