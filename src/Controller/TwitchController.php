<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Service\TwitchApiService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TwitchController extends Controller
{
    /** @var TwitchApiWrapper */
    private $twitchApiWrapper;

    public function __construct(TwitchApiWrapper $twitchApiWrapper)
    {
        $this->twitchApiWrapper = $twitchApiWrapper;
    }

    /**
     * @Route("/twitch/denied", name="twitch_denied")
     */
    public function index(): Response
    {
        return $this->render('twitch/index.html.twig', [
            'nav'     => 'twitch',
            'channel' => '',
            'user'    => '',
        ]);
    }

    /**
     * @Route("/twitch/get_auth", name="twitch_auth")
     */
    public function getAuth(): Response
    {
        return $this->redirect(
            $this->twitchApiWrapper->getAccessTokenUrl(TwitchApiService::SCOPE_CHANNEL)
        );
    }

    /**
     * @Route("/twitch/get_access", name="twitch_access")
     */
    public function getAccess(): Response
    {
        return $this->render('twitch/access.html.twig', [
            'nav'     => 'twitch',
            'channel' => '',
            'user'    => '',
        ]);
    }

    /**
     * @Route("/twitch/redirect", name="twitch_redirect")
     */
    public function redirectAction(Request $request): Response
    {
        $oAuth = $request->get('access_token');
        if ($oAuth === null) {
            return $this->redirectToRoute('index');
        }

        $session = new Session();
        $session->set(TwitchApiWrapper::SESSION_OAUTH_KEY, $oAuth);
        $request->setSession($session);

        return $this->redirectToRoute('index');
    }
}
