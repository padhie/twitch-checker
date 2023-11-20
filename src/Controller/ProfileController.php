<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Exception\UserNotExistsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends Controller
{
    public function __construct(private readonly TwitchApiWrapper $twitchApiWrapper)
    {
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
        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);

        $userName = $request->get('user', '');
        try {
            $user = $this->twitchApiWrapper->getUserByName($userName);
        } catch (UserNotExistsException | ApiErrorException) {
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/profile.html.twig', [
            'nav'     => 'profile',
            'user'    => $user->getDisplayName(),
            'channel' => $user->jsonSerialize(),
        ]);
    }
}
