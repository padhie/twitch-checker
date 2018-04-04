<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 01.01.2018
 * Time: 18:33
 */

namespace App\Service;

use AppBundle\Model\TwitchApi\TwitchChannel;
use AppBundle\Model\TwitchApi\TwitchEmoticon;
use AppBundle\Model\TwitchApi\TwitchFollower;
use AppBundle\Model\TwitchApi\TwitchHost;
use AppBundle\Model\TwitchApi\TwitchStream;
use AppBundle\Model\TwitchApi\TwitchTeam;
use AppBundle\Model\TwitchApi\TwitchUser;
use AppBundle\Model\TwitchApi\TwitchVideo;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class TwitchApiService
 * @package AppBundle\Service
 */
class TwitchApiService
{
    /**
     * @var array
     */
    public static $SCOPE_USER = [
        'user_read',
        'user_follows_edit',
    ];

    /**
     * @var array
     */
    public static $SCOPE_CHANNEL = [
        'channel_read',
        'channel_stream',
        'channel_editor',
        'channel_subscriptions',
        'channel_check_subscription',
        'channel_commercial',
    ];


    /**
     * @var string
     */
    private $client_id;

    /**
     * @var string
     */
    private $client_secret;

    /**
     * @var string
     */
    private $redirect_url;

    /**
     * @var string
     */
    private $base_url = "https://api.twitch.tv/kraken/";

    /**
     * @var string
     */
    private $header_application = 'application/vnd.twitchtv.v5+json';

    /**
     * @var string
     */
    private $oauth;

    /**
     * @var string
     */
    private $additional_string;

    /**
     * @var string
     */
    private $_raw_reponse;

    /**
     * @var array
     */
    private $response;

    /**
     * @var integer
     */
    private $channel_id;

    /**
     * @var string
     */
    private $channel_name;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var integer
     */
    private $video_id;


    // #########################
    // # SETTER/HETTER METHODS #
    // #########################
    /**
     * @param string $clientId
     *
     * @return TwitchApiService
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * @param string $clientSecret
     *
     * @return TwitchApiService
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * @param string $redirectUrl
     *
     * @return TwitchApiService
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirect_url = $redirectUrl;

        return $this;
    }

    /**
     * @param string $oauth
     *
     * @return TwitchApiService
     */
    public function setOAuth($oauth)
    {
        $this->oauth = $oauth;

        return $this;
    }

    /**
     * @param string $sAdditional
     *
     * @return TwitchApiService
     */
    public function setAdditionalString($sAdditional)
    {
        $this->additional_string = $sAdditional;

        return $this;
    }

    /**
     * @param array $scopeList
     *
     * @return string
     */
    public function getAccesTokenUrl($scopeList = [])
    {
        $scope = implode('+', $scopeList);

        $sUrl    = $this->base_url . "oauth2/authorize?";
        $sParams = "response_type=token" .
            "&client_id=" . $this->client_id .
            "&scope=" . $scope .
            "&redirect_uri=" . $this->redirect_url;

        return $sUrl . $sParams;
    }

    /**
     * @param $channelId
     *
     * @return TwitchApiService
     */
    public function setChannelId($channelId)
    {
        $this->channel_id = $channelId;

        return $this;
    }

    /**
     * @return int
     */
    public function getChannelId()
    {
        return $this->channel_id;
    }

    /**
     * @param $channelName
     *
     * @return TwitchApiService
     */
    public function setChannelName($channelName)
    {
        $this->channel_name = $channelName;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannelName()
    {
        return $this->channel_name;
    }

    /**
     * @param $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param $videoId
     *
     * @return $this
     */
    public function setVideoId($videoId)
    {
        $this->video_id = $videoId;

        return $this;
    }

    /**
     * @return int
     */
    public function getVideoId()
    {
        return $this->video_id;
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    private function getHeader()
    {
        return [
            'Accept: ' . $this->header_application,
            'Client-ID: ' . $this->client_id,
            'Authorization: OAuth ' . $this->oauth,
            'Cache-Control: no-cache',
        ];
    }


    // ################
    // # BASE METHODS #
    // ################
    /**
     * @param string $urlextension url entpoint
     * @param array  $data         Key => Value
     *
     * @return TwitchApiService
     * @throws \Exception
     */
    protected function get($urlextension = '', $data = [], $header = [])
    {
        $additional_string = $this->additional_string;
        if (is_array($data) && !empty($data)) {
            $dataList = [];
            foreach ($data AS $key => $value) {
                $dataList[] = $key . '=' . $value;
            }
            $additional_string .= '?' . implode("&", $dataList);
        }

        if (empty($header)) {
            $header = $this->getHeader();
        }

        $url  = $this->base_url . $urlextension . $additional_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->_raw_reponse = curl_exec($curl);
        $this->response     = json_decode($this->_raw_reponse, true);
        curl_close($curl);

        if (isset($this->response['error'])) {
            $message = $this->response['message'];
            if (empty($message)) {
                $message = $this->response['error'];
            }
            throw new \Exception($url . ' - ' . $message, $this->response['status']);
        }

        return $this;
    }

    /**
     * @param string $urlextension url entpoint
     * @param array  $data         Key => Value
     *
     * @return TwitchApiService
     * @throws \Exception
     */
    protected function put($urlextension = '', $data = [], $header = [])
    {
        if (empty($header)) {
            $header = $this->getHeader();
        }

        $url  = $this->base_url . $urlextension . $this->additional_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $this->_raw_reponse = curl_exec($curl);
        $this->response     = json_decode($this->_raw_reponse, true);
        curl_close($curl);

        if (isset($this->response['error'])) {
            $message = $this->response['message'];
            if (empty($message)) {
                $message = $this->response['error'];
            }
            throw new \Exception($url . ' - ' . $message, $this->response['status']);
        }

        return $this;
    }


    // ################
    // # USER METHODS #
    // ################
    /**
     * Scope: user_read
     *
     * @param string $name
     *
     * @return TwitchUser
     * @throws \Exception
     */
    public function getUserByName($name)
    {
        $this->get('users?login=' . $name);
        $user = new TwitchUser();
        $user->setDataByJson($this->getData()['users'][0]);

        return $user;
    }

    /**
     * Scope: user_read
     *
     * @return TwitchUser
     * @throws \Exception
     */
    public function getUser()
    {
        $this->get('user');
        $user = new TwitchUser();
        $user->setDataByJson($this->getData());

        return $user;
    }

    /**
     * Scope: -
     *
     * @return TwitchUser
     * @throws \Exception
     */
    public function getUserById()
    {
        $this->get('users/' . $this->getUserId());
        $user = new TwitchUser();
        $user->setDataByJson($this->getData());

        return $user;
    }

    /**
     * Scope: user_subscriptions
     *
     * @return bool
     * @throws \Exception
     */
    public function isUserSubscribingChannel()
    {
        try {
            $this->get('users/' . $this->getUserId() . '/subscriptions/' . $this->getChannelId());
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'no subscriptions')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Scope: -
     *
     * @return bool
     * @throws \Exception
     */
    public function isUserFollowingChannel()
    {
        try {
            $this->get('users/' . $this->getUserId() . '/follows/channels/' . $this->getChannelId());
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'is not following')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Scope: -
     *
     * @return TwitchFollower[]
     * @throws \Exception
     */
    public function getUserFollowingChannel()
    {
        $this->get('users/' . $this->getUserId() . '/follows/channels');

        $followerList = [];
        foreach ($this->getData()['follows'] AS $followerData) {
            $follower = new TwitchFollower();
            $follower->setDataByJson($followerData);
            $followerList[] = $follower;
        }

        return $followerList;
    }

    /**
     * Scope: user_follows_edit
     *
     * @return TwitchChannel
     * @throws \Exception
     */
    public function setUserFollowingChannel()
    {
        $this->put('users/' . $this->getUserId() . '/follows/channels/' . $this->getChannelId());
        $channel = new TwitchChannel();
        $channel->setDataByJson($this->getData());

        return $channel;
    }


    // ###################
    // # CHANNEL METHODS #
    // ###################
    /**
     * Scope: channel_read
     *
     * @return TwitchChannel
     * @throws \Exception
     */
    public function getChannel()
    {
        $this->get("channel");
        $channel = new TwitchChannel();
        $channel->setDataByJson($this->getData());

        return $channel;
    }

    /**
     * Scope: -
     *
     * @return TwitchChannel
     * @throws \Exception
     */
    public function getChannelById()
    {
        $this->get("channels/" . $this->getChannelId());
        $channel = new TwitchChannel();
        $channel->setDataByJson($this->getData());

        return $channel;
    }

    /**
     * Scope: -
     *
     * @return TwitchFollower[]
     * @throws \Exception
     */
    public function getFollowerList()
    {
        $this->get('channels/' . $this->getChannelId() . '/follows');

        $followerList = [];
        foreach ($this->getData()['follows'] AS $followData) {
            $follower = new TwitchFollower();

            $follower->setDataByJson($followData);

            $followerList[] = $follower;
        }

        return $followerList;
    }

    /**
     * Scope: -
     *
     * @return TwitchTeam[]
     * @throws \Exception
     */
    public function getTeamList()
    {
        $this->get('channels/' . $this->getChannelId() . '/team');

        $teamList = [];
        foreach ($this->getData()['follows'] AS $teamData) {
            $team = new TwitchTeam();
            $team->setDataByJson($teamData);
            $teamList[] = $team;
        }

        return $teamList;
    }

    /**
     * Scope: channel_editor
     *
     * @param string $title
     *
     * @return TwitchChannel
     * @throws \Exception
     */
    public function changeChannelTitle($title)
    {
        $data = [
            'channel[status]' => $title,
        ];
        $this->put('channels/' . $this->getChannelId(), $data);

        $channel = new TwitchChannel();
        $channel->setDataByJson($this->getData());

        return $channel;
    }

    /**
     * Scope: channel_editor
     *
     * @param string $game
     *
     * @return TwitchChannel
     * @throws \Exception
     */
    public function changeChannelGame($game)
    {
        $data = [
            'channel[game]' => $game,
        ];
        $this->put('channels/' . $this->getChannelId(), $data);

        $channel = new TwitchChannel();
        $channel->setDataByJson($this->getData());

        return $channel;
    }

    /**
     * Data get out from API
     *
     * Scope: -
     *
     * @return TwitchHost[]
     * @throws \Exception
     */
    public function getHostings()
    {
        $_tmpBaseUrl    = $this->base_url;
        $this->base_url = 'https://tmi.twitch.tv/';
        $this->get("hosts?include_logins=1&target=" . $this->getChannelId(), [], ['Cache-Control: no-cache']);
        $this->base_url = $_tmpBaseUrl;

        $origChannelId = $this->getChannelId();
        $data          = $this->getData();
        $hostList      = [];
        foreach ($data["hosts"] AS $host) {
            $twitchHost = new TwitchHost();

            $this->setChannelId($host['host_id']);
            $twitchHost->setChannel($this->getChannelById());

            $this->setChannelId($host['target_id']);
            $twitchHost->setTarget($this->getChannelById());

            if (isset($host['host_recent_chat_activity_count'])) {
                $twitchHost->setViewer($host['host_recent_chat_activity_count']);
            }

            $hostList[] = $twitchHost;
        }
        $this->setChannelId($origChannelId);

        return $hostList;
    }


    // ##################
    // # STREAM METHODS #
    // ##################
    /**
     * Scope: -
     *
     * @return TwitchStream|null Return TwitchStream if data return else NULL
     *
     * @throws \Exception
     */
    public function getStream()
    {
        $this->get('streams/' . $this->getChannelId());
        $returnData = $this->getData();

        if ($returnData['stream']) {
            $stream = new TwitchStream();
            $stream->setDataByJson($returnData['stream']);

            return $stream;
        }

        return null;
    }

    /**
     * Scope: user_read
     *
     * Return a list of all online and playlist streams
     *
     * @return TwitchStream[]
     * @throws \Exception
     */
    public function getFollowingStreamList()
    {
        $this->get('streams/followed', ['stream_type' => 'all']);

        $streamList = [];
        foreach ($this->getData()['streams'] AS $streamData) {
            $stream = new TwitchStream();

            $stream->setDataByJson($streamData);

            $streamList[] = $stream;
        }

        return $streamList;
    }


    // ################
    // # CHAT METHODS #
    // ################
    /**
     * Scope: -
     *
     * @return array
     * @throws \Exception
     */
    public function getBadgeList()
    {
        $this->get('chat/' . $this->getChannelId() . '/badges');

        return $this->getData();
    }

    /**
     * Data get out from API
     *
     * Scope: -
     *
     * @return string
     * @throws \Exception
     */
    public function getUserList()
    {
        $_tmpBaseUrl    = $this->base_url;
        $this->base_url = 'https://tmi.twitch.tv/';
        $this->get('group/user/' . $this->getChannelName() . '/chatters', [], ['Cache-Control: no-cache']);
        $this->base_url = $_tmpBaseUrl;

        return $this->_raw_reponse;
    }

    /**
     * Scope: -
     *
     * @return TwitchEmoticon[]
     * @throws \Exception
     */
    public function getEmoticonList()
    {
        $this->get('chat/emoticons');

        $emoticonList = [];
        foreach ($this->getData()['emoticons'] AS $emoticonsData) {
            $emoticon = new TwitchEmoticon();
            $emoticon->setDataByJson($emoticonsData);
            $emoticonList[] = $emoticon;
        }

        return $emoticonList;
    }


    // #################
    // # VIDEO METHODS #
    // #################
    /**
     * Scope: -
     *
     * @return TwitchVideo
     * @throws \Exception
     */
    public function getVideoById()
    {
        $this->get('videos/' . $this->getVideoId());
        $video = new TwitchVideo();
        $video->setDataByJson($this->getData());

        return $video;
    }
}