<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends Controller
{
    public function __construct(private readonly ApiService $apiService, private readonly TwitchApiWrapper $twitchApiWrapper)
    {
    }

    /**
     * @Route("/api/online", name="api_online")
     */
    public function online(Request $request): Response
    {
        if (!$this->apiService->checkByRequest($request)) {
            throw $this->createAccessDeniedException();
        }

        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);
        $names = explode(',', (string) $request->get('users', ''));

        $streams = [];
        try {

            foreach ($names as $name) {
                $user = $this->twitchApiWrapper->getUserByName($name);
                $channelId = $user->getId();
                $stream = $this->twitchApiWrapper->getStream($channelId);

                if ($stream === null) {
                    continue;
                }

                $streams[] = [
                    'userId' => $channelId,
                    'username' => $user->getLogin(),
                    'displayName' => $user->getDisplayName(),
                    'url' => sprintf('https://twitch.tv/%s', $user->getLogin()),
                    'profileImageURL' => $user->getProfileImageUrl(),
                    'title' => $stream->getTitle(),
                    'game' => $stream->getGameName(),
                ];
            }
        } catch (UserNotExistsException) {
        }

        return new JsonResponse([
            'streams' => $streams,
        ]);
    }
}