<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TwitchApiBundle\Exception\UserNotExistsException;
use TwitchApiBundle\Helper\TwitchApiModelHelper;
use TwitchApiBundle\Service\TwitchApiService;

class ProfileController extends Controller
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
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig', [
            'nav'  => 'profile',
            'user' => '',
        ]);
    }

    /**
     * @Route("/profile/check", name="profile_check")
     */
    public function check(Request $request)
    {
        $user = $request->get('user', '');

        try {
            $user = $this->twitchApi->getUserByName($user);
            $channelId = $user->getId();
        } catch (UserNotExistsException $e) {
            $channelId = (int)$user;
        }

        $this->twitchApi->setChannelId($channelId);
        $user = $this->twitchApi->getChannelById();

        return $this->render('profile/profile.html.twig', [
            'nav'     => 'profile',
            'user'    => $user->getName(),
            'channel' => TwitchApiModelHelper::convertToArray($user),
        ]);
    }
}
