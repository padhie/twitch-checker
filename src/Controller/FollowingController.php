<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TwitchApiBundle\Exception\UserNotExistsException;
use TwitchApiBundle\Helper\TwitchApiModelHelper;
use TwitchApiBundle\Service\TwitchApiService;

class FollowingController extends Controller
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
     * @Route("/following", name="following")
     */
    public function index()
    {
        return $this->render('following/index.html.twig', [
            'nav'     => 'following',
            'channel' => '',
            'user'    => '',
        ]);
    }

    /**
     * @Route("/following/check", name="following_check")
     */
    public function check(Request $request)
    {
        $user = $request->get('user', '');
        $channel = $request->get('channel', '');
        $following = null;

        try {
            $userData = $this->twitchApi->getUserByName($user);
            $userId = $userData->getId();
        } catch (UserNotExistsException $e) {
            $userId = (int)$user;
        }

        try {
            $channelData = $this->twitchApi->getUserByName($channel);
            $channelId = $channelData->getId();
        } catch (UserNotExistsException $e) {
            $channelId = (int)$channel;
        }

        $this->twitchApi->setUserId($userId)->setChannelId($channelId);
        if ($userId !== 0
            && $channelId !== 0
            && $this->twitchApi->isUserFollowingChannel()) {
            $this->twitchApi->setUserId($userId)->setChannelId($channelId)->isUserFollowingChannel();
            $following = $this->twitchApi->getUserFollowingChannel();
        }

        return $this->render('following/following.html.twig', [
            'nav'       => 'following',
            'channel'   => $following ? $following->getChannel()->getName() : $channel,
            'user'      => $user,
            'following' => $following ? TwitchApiModelHelper::convertToArray($following) : null,
        ]);
    }
}
