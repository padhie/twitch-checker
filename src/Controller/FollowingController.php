<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowingController extends Controller
{
    public function __construct(private readonly TwitchApiWrapper $twitchApiWrapper)
    {
    }

    /**
     * @Route("/following", name="following")
     */
    public function index(): Response
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
    public function check(Request $request): Response
    {
        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);

        $user = $request->get('user', '');
        $channel = $request->get('channel', '');
        $following = null;

        try {
            $userData = $this->twitchApiWrapper->getUserByName($user);
            $userId = $userData->getId();
        } catch (ApiErrorException|UserNotExistsException $e) {
            $userId = (int)$user;
        }

        try {
            $channelData = $this->twitchApiWrapper->getUserByName($channel);
            $channelId = $channelData->getId();
        } catch (ApiErrorException|UserNotExistsException) {
            $channelId = (int)$channel;
        }

        if ($userId !== 0
            && $channelId !== 0
            && $this->twitchApiWrapper->isUserFollowingChannel($userId, $channelId)
        ) {
            $following = $this->twitchApiWrapper->getUserFollowingChannel($userId, $channelId);
        }

        return $this->render('following/following.html.twig', [
            'nav'       => 'following',
            'channel'   => $following->getFromName(),
            'user'      => $user,
            'following' => $following !== null ? $following->jsonSerialize() : null,
        ]);
    }
}
