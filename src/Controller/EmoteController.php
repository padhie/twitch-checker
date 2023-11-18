<?php

namespace App\Controller;

use App\Service\TwitchApiWrapper;
use Padhie\TwitchApiBundle\Exception\ApiErrorException;
use Padhie\TwitchApiBundle\Model\TwitchModelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmoteController extends Controller
{
    public function __construct(private readonly TwitchApiWrapper $twitchApiWrapper)
    {
    }

    /**
     * @Route("/emotes", name="emotes")
     */
    public function index(): Response
    {
        return $this->render('emotes/index.html.twig', [
            'nav'           => 'emotes',
            'emoticonSetId' => '',
        ]);
    }

    /**
     * @Route("/emotes/check", name="emotes_check")
     */
    public function check(Request $request): Response
    {
        $this->twitchApiWrapper->checkAndUseRequestOAuth($request);

        $emoticonSetId = $request->get('emoticonSetId', '');
        $returnEmoticonList = [];
        try {
            $emoteList = $this->twitchApiWrapper->getEmoticonImageListByEmoteiconSets($emoticonSetId);
            $returnEmoticonList = array_map(static fn(TwitchModelInterface $item) => $item->jsonSerialize(), $emoteList);
        } catch (ApiErrorException) {
        }

        return $this->render('emotes/emotes.html.twig', [
            'nav'           => 'emotes',
            'emoticonSetId' => $emoticonSetId,
            'emoteList'     => $returnEmoticonList ?? [],

        ]);
    }
}
