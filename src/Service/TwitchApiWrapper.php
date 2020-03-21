<?php

namespace App\Service;

use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Padhie\TwitchApiBundle\Model\TwitchChannel;
use Padhie\TwitchApiBundle\Model\TwitchChannelSubscriptions;
use Padhie\TwitchApiBundle\Model\TwitchFollower;
use Padhie\TwitchApiBundle\Model\TwitchStream;
use Padhie\TwitchApiBundle\Model\TwitchUser;
use Padhie\TwitchApiBundle\Service\TwitchApiService;
use Symfony\Component\HttpFoundation\Request;

class TwitchApiWrapper
{
    public const SESSION_OAUTH_KEY = 'twitchOAuth';
    private const ACCESS_DENIED_EXCEPTION_MESSAGE = 'Unable to access channel subscribers of';

    /** @var TwitchApiService */
    private $twitchApi;

    public function __construct()
    {
        $this->twitchApi = new TwitchApiService(getenv('TWITCH_CLIENT_ID'), getenv('TWITCH_SECRET'), getenv('TWITCH_REDIRECT_URL'));
        $this->twitchApi->setOAuth(getenv('TWITCH_ACCESS_TOKEN'));
    }

    public function checkAndUseRequestOAuth(Request $request): void
    {
        $session = $request->getSession();
        if ($session && $session->get(self::SESSION_OAUTH_KEY)) {
            $this->twitchApi->setOAuth($session->get(self::SESSION_OAUTH_KEY));
        }
    }

    public function isAccessException(ApiErrorException $exception): bool
    {
        return strpos($exception->getMessage(), self::ACCESS_DENIED_EXCEPTION_MESSAGE) !== false;
    }

    /**
     * @param array<int, string> $scopeList
     */
    public function getAccessTokenUrl(array $scopeList = []): string
    {
        return $this->twitchApi->getAccessTokenUrl($scopeList);
    }

    /**
     * @throws ApiErrorException
     * @throws UserNotExistsException
     */
    public function getUserByName(string $name): TwitchUser
    {
        return $this->twitchApi->getUserByName($name);
    }

    /**
     * @throws ApiErrorException
     */
    public function getStream(int $channelId = 0): ?TwitchStream
    {
        return $this->twitchApi->getStream($channelId);
    }

    /**
     * @throws ApiErrorException
     */
    public function getChannelById(int $channelId = 0): TwitchChannel
    {
        return $this->twitchApi->getChannelById($channelId);
    }

    public function isUserFollowingChannel(int $userId = 0, int $channelId = 0): bool
    {
        return $this->twitchApi->isUserFollowingChannel($userId, $channelId);
    }

    public function getUserFollowingChannel(): TwitchFollower
    {
        return $this->twitchApi->getUserFollowingChannel();
    }

    /**
     * @throws ApiErrorException
     */
    public function getEmoticonImageListByEmoteiconSets(string $emoticonsets): array
    {
        return $this->twitchApi->getEmoticonImageListByEmoteiconSets($emoticonsets);
    }

    /**
     * @throws ApiErrorException
     */
    public function getChannelSubscriber(int $channelId = 0): TwitchChannelSubscriptions
    {
        return $this->twitchApi->getChannelSubscriber($channelId);
    }
}