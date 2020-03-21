<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends Controller
{
    /** @var TwitchApiWrapper */
    private $twitchApiWrapper;

    public function __construct(TwitchApiWrapper $twitchApiWrapper)
    {
        $this->twitchApiWrapper = $twitchApiWrapper;
    }

    /**
     * @Route("/subscription", name="subscription")
     */
    public function index(): Response
    {
        return $this->render('subscription/index.html.twig', [
            'nav'     => 'subscription',
            'channel' => '',
            'user'    => '',
        ]);
    }

    /**
     * @Route("/subscription/check", name="subscription_check")
     */
    public function check(Request $request): Response
    {
        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);

        $channel = $request->get('channel', '');
        $channelId = $channel;
        $subscribe = null;

        if (!is_int($channel)) {
            try {
                $channelData = $this->twitchApiWrapper->getUserByName($channel);
                $channelId = $channelData->getId();
            } catch (ApiErrorException|UserNotExistsException $e) {
                $channelId = 0;
            }
        }

        if ($channelId !== 0) {
            try {
                $subscribe = $this->twitchApiWrapper->getChannelSubscriber($channelId);
            } catch (ApiErrorException $e) {
                if ($this->twitchApiWrapper->isAccessException($e)) {
                    return $this->redirectToRoute('twitch_denied');
                }
            }
        }

        return $this->render('subscription/subscription.html.twig', [
            'nav'       => 'subscription',
            'channel'   => $channel,
            'subscribe' => $subscribe ? $subscribe->jsonSerialize() : null,
        ]);
    }
}
