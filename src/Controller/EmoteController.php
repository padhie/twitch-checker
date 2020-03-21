<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TwitchApiBundle\Exception\ApiErrorException;
use TwitchApiBundle\Helper\TwitchApiModelHelper;
use TwitchApiBundle\Service\TwitchApiService;

class EmoteController extends Controller
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
     * @Route("/emotes", name="emotes")
     */
    public function index()
    {
        return $this->render('emotes/index.html.twig', [
            'nav'           => 'emotes',
            'emoticonSetId' => '',
        ]);
    }

    /**
     * @Route("/emotes/check", name="emotes_check")
     */
    public function check(Request $request)
    {
        $emoticonSetId = $request->get('emoticonSetId', '');
        $returnEmoticonList = [];
        try {
            $emoteList = $this->twitchApi->getEmoticonImageListByEmoteiconSets($emoticonSetId);
            $returnEmoticonList = array_map(function($item) {
                return TwitchApiModelHelper::convertToArray($item);
            }, $emoteList);
        } catch (ApiErrorException $e) {
        }

        return $this->render('emotes/emotes.html.twig', [
            'nav'           => 'emotes',
            'emoticonSetId' => $emoticonSetId,
            'emoteList'     => $returnEmoticonList ?? [],

        ]);
    }
}
