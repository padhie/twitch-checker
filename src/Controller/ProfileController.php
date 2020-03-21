<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends Controller
{
    /** @var TwitchApiWrapper */
    private $twitchApiWrapper;

    public function __construct(TwitchApiWrapper $twitchApiWrapper)
    {
        $this->twitchApiWrapper = $twitchApiWrapper;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'nav'  => 'profile',
            'user' => '',
        ]);
    }

    /**
     * @Route("/profile/check", name="profile_check")
     */
    public function check(Request $request): Response
    {
        $user = $request->get('user', '');

        try {
            $user = $this->twitchApiWrapper->getUserByName($user);
            $channelId = $user->getId();
        } catch (UserNotExistsException $e) {
            $channelId = (int)$user;
        }

        $user = $this->twitchApiWrapper->getChannelById($channelId);

        return $this->render('profile/profile.html.twig', [
            'nav'     => 'profile',
            'user'    => $user->getName(),
            'channel' => $user->jsonSerialize(),
        ]);
    }
}
