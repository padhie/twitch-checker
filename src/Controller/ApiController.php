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
    /** @var ApiService */
    private $apiService;
    /** @var TwitchApiWrapper */
    private $twitchApiWrapper;

    public function __construct(ApiService $apiService, TwitchApiWrapper $twitchApiWrapper)
    {
        $this->apiService = $apiService;
        $this->twitchApiWrapper = $twitchApiWrapper;
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
        $names = explode(',', $request->get('users', ''));

        $streams = [];
        try {

            foreach ($names as $name) {
                $user = $this->twitchApiWrapper->getUserByName($name);
                $channelId = $user->getId();
                $stream = $this->twitchApiWrapper->getStream($channelId);

                if (!$stream) {
                    continue;
                }

                $streams[] = [
                    'userId' => $channelId,
                    'username' => $stream->getChannel()->getName(),
                    'displayName' => $stream->getChannel()->getDisplayName(),
                    'url' => $stream->getChannel()->getUrl(),
                    'profileImageURL' => $stream->getChannel()->getLogo(),
                    'title' => $stream->getChannel()->getStatus(),
                    'game' => $stream->getChannel()->getGame(),
                ];
            }
        } catch (UserNotExistsException $e) {
        }

        return new JsonResponse([
            'streams' => $streams,
        ]);
    }
}