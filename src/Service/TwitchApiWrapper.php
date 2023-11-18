<?php

namespace App\Service;

use Padhie\SsoClient\Twitch\ClientWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Padhie\TwitchApiBundle\Request\Channels\GetChannelInformationRequest;
use Padhie\TwitchApiBundle\Request\Streams\GetStreamsRequest;
use Padhie\TwitchApiBundle\Request\Subscriptions\GetBroadcasterSubscriptionsRequest;
use Padhie\TwitchApiBundle\Request\Users\GetUsersFollowsRequest;
use Padhie\TwitchApiBundle\Request\Users\GetUsersRequest;
use Padhie\TwitchApiBundle\Response\Channels\Channel;
use Padhie\TwitchApiBundle\Response\Channels\GetChannelInformationResponse;
use Padhie\TwitchApiBundle\Response\Streams\GetStreamsResponse;
use Padhie\TwitchApiBundle\Response\Streams\Stream;
use Padhie\TwitchApiBundle\Response\Subscriptions\GetBroadcasterSubscriptionsResponse;
use Padhie\TwitchApiBundle\Response\Subscriptions\Subscription;
use Padhie\TwitchApiBundle\Response\Users\FollowerUser;
use Padhie\TwitchApiBundle\Response\Users\GetUsersFollowsResponse;
use Padhie\TwitchApiBundle\Response\Users\GetUsersResponse;
use Padhie\TwitchApiBundle\Response\Users\User;
use Padhie\TwitchApiBundle\TwitchAuthenticator;
use Padhie\TwitchApiBundle\TwitchClient;
use Symfony\Component\HttpFoundation\Request;

final readonly class TwitchApiWrapper
{
    final public const SESSION_OAUTH_KEY = 'twitchOAuth';
    private const ACCESS_DENIED_EXCEPTION_MESSAGE = 'Unable to access channel subscribers of';

    private TwitchClient $client;
    private TwitchAuthenticator $authenticator;

    public function __construct()
    {
        $this->client = ClientWrapper::build('abc');
        $this->authenticator = new TwitchAuthenticator(getenv('TWITCH_CLIENT_ID'), getenv('TWITCH_REDIRECT_URL'));
    }

    public function checkAndUseRequestOAuth(Request $request): void
    {
    }

    public function isAccessException(ApiErrorException $exception): bool
    {
        return str_contains($exception->getMessage(), self::ACCESS_DENIED_EXCEPTION_MESSAGE);
    }

    /**
     * @param array<int, string> $scopeList
     */
    public function getAccessTokenUrl(array $scopeList = []): string
    {
        return $this->authenticator->getAccessTokenUrl($scopeList);
    }

    /**
     * @throws ApiErrorException
     * @throws UserNotExistsException
     */
    public function getUserByName(string $name): User
    {
        $request = new GetUsersRequest(null, $name);

        $response = $this->client->send($request);
        if (!$response instanceof GetUsersResponse) {
            throw new ApiErrorException('Client-Response-Error', 1700321699613);
        }

        $users = $response->getUsers();
        if (count($users) < 1) {
            throw new UserNotExistsException();
        }

        return reset($users);
    }

    /**
     * @throws ApiErrorException
     */
    public function getStream(int $channelId = 0): ?Stream
    {
        $request = (new GetStreamsRequest())
            ->withUserId($channelId);

        $response = $this->client->send($request);
        if (!$response instanceof GetStreamsResponse) {
            throw new ApiErrorException('Client-Response-Error', 1700321862995);
        }

        return $response->getStreams()[0] ?? null;
    }

    /**
     * @throws ApiErrorException
     */
    public function getChannelById(int $channelId = 0): Channel
    {
        $request = new GetChannelInformationRequest($channelId);

        $response = $this->client->send($request);
        if (!$response instanceof GetChannelInformationResponse) {
            throw new ApiErrorException('Client-Response-Error', 1700322205834);
        }

        $channels = $response->getChannels();
        if (count($channels) <= 1) {
            throw new ApiErrorException('Channel not exists', 1700322254395);
        }

        return reset($channels);
    }

    public function isUserFollowingChannel(int $userId = 0, int $channelId = 0): bool
    {

        try {
            $follower = $this->getUserFollowingChannel($userId, $channelId);
        } catch (ApiErrorException) {
            return false;
        }

        return $follower !== null;
    }

    public function getUserFollowingChannel(int $userId = 0, int $channelId = 0): ?FollowerUser
    {
        $request = new GetUsersFollowsRequest($channelId, $userId);

        $response = $this->client->send($request);
        if (!$response instanceof GetUsersFollowsResponse) {
            throw new ApiErrorException('Client-Response-Error', 1700322449438);
        }

        $followers = $response->getFollowerUsers();

        return count($followers) >= 1
            ? reset($followers)
            : null;
    }

    /**
     * @throws ApiErrorException
     */
    public function getEmoticonImageListByEmoteiconSets(string $emoticonsets): array
    {
        return [];
    }

    /**
     * @throws ApiErrorException
     */
    public function getChannelSubscriber(int $channelId = 0): Subscription
    {
        $request = new GetBroadcasterSubscriptionsRequest($channelId);
        $response = $this->client->send($request);
        if (!$response instanceof GetBroadcasterSubscriptionsResponse) {
            throw new ApiErrorException('Client-Response-Error', 1700322939938);
        }

        $subscriptions = $response->getSubscriptions();
        if (count($subscriptions) === 0) {
            throw new ApiErrorException('Client-Response-time', 1700322978893);
        }

        return reset($subscriptions);
    }
}