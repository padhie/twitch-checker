<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TwitchApiBundle\Exception\UserNotExistsException;
use TwitchApiBundle\Helper\TwitchApiModelHelper;
use TwitchApiBundle\Service\TwitchApiService;

class StreamController extends Controller
{
    /**
     * @var TwitchApiService
     */
    private $twitchApi;

    public function __construct()
    {
        // http://twitch-checker.padhie.de/#access_token=twgtu0zf28po214uqppgtqtvl0n75v&scope=channel_read+channel_stream+channel_editor+channel_subscriptions+channel_check_subscription+channel_commercial+user_read+user_follows_edit
        $this->twitchApi = new TwitchApiService(getenv('TWITCH_CLIENT_ID'), getenv('TWITCH_SECRET'), getenv('TWITCH_REDIRECT_URL'));
        $this->twitchApi->setOAuth(getenv('TWITCH_ACCESS_TOKEN'));
    }

    /**
     * @Route("/stream", name="stream")
     */
    public function index()
    {
        return $this->render('stream/index.html.twig', [
            'nav'  => 'stream',
            'user' => '',
        ]);
    }

    /**
     * @Route("/stream/check", name="stream_check")
     */
    public function check(Request $request)
    {
        $name = $request->get('user', '');

        try {
            $user = $this->twitchApi->getUserByName($name);
            $channelId = $user->getId();
        } catch (UserNotExistsException $e) {
            $channelId = (int)$name;
        }

        $this->twitchApi->setChannelId($channelId);
        $stream = $this->twitchApi->getStream();

        return $this->render('stream/stream.html.twig', [
            'nav'    => 'stream',
            'user'   => $stream ? $stream->getChannel()->getName() : $name,
            'stream' => $stream ? TwitchApiModelHelper::convertToArray($stream) : null,
        ]);
    }
}
