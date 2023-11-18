<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends Controller
{
    public function __construct(private readonly TwitchApiWrapper $twitchApiWrapper)
    {
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
        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);

        $name = $request->get('user', '');
        $user = $stream = null;

        try {
            $user = $this->twitchApiWrapper->getUserByName($name);
        } catch (UserNotExistsException | ApiErrorException) {
            // do nothing
        }

        if ($user !== null) {
            $channelId = $user->getId();
            $stream = $this->twitchApiWrapper->getStream($channelId);
        }

        return $this->render('stream/stream.html.twig', [
            'nav'    => 'stream',
            'user'   => $user?->getDisplayName(),
            'stream' => $stream?->jsonSerialize(),
        ]);
    }
}
