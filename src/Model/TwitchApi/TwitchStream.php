<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 14:28
 */

namespace AppBundle\Model\TwitchApi;


class TwitchStream
{
    /**
     * @var integer
     */
    private $_id;

    /**
     * @var string
     */
    private $game;

    /**
     * @var integer
     */
    private $viewers;

    /**
     * @var integer
     */
    private $video_height;

    /**
     * @var integer
     */
    private $average_fps;

    /**
     * @var integer
     */
    private $delay;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var boolean
     */
    private $is_playlist;

    /**
     * @var string[]
     */
    private $preview;

    /**
     * @var TwitchChannel
     */
    private $channel;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setId($json['_id']);
        $this->setGame($json['game']);
        $this->setVideoHeight($json['viewers']);
        $this->setVideoHeight($json['video_height']);
        $this->setAverageFps($json['average_fps']);
        $this->setDelay($json['delay']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setIsPlaylist($json['is_playlist']);
        $this->setPreview($json['preview']);

        $channel = new TwitchChannel();
        $channel->setDataByJson($json['channel']);
        $this->setChannel($channel);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param string $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return int
     */
    public function getViewers()
    {
        return $this->viewers;
    }

    /**
     * @param int $viewers
     */
    public function setViewers($viewers)
    {
        $this->viewers = $viewers;
    }

    /**
     * @return int
     */
    public function getVideoHeight()
    {
        return $this->video_height;
    }

    /**
     * @param int $video_height
     */
    public function setVideoHeight($video_height)
    {
        $this->video_height = $video_height;
    }

    /**
     * @return int
     */
    public function getAverageFps()
    {
        return $this->average_fps;
    }

    /**
     * @param int $average_fps
     */
    public function setAverageFps($average_fps)
    {
        $this->average_fps = $average_fps;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param int $delay
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return bool
     */
    public function isPlaylist()
    {
        return $this->is_playlist;
    }

    /**
     * @param bool $is_playlist
     */
    public function setIsPlaylist($is_playlist)
    {
        $this->is_playlist = $is_playlist;
    }

    /**
     * @return string[]
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param string[] $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    /**
     * @return TwitchChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param TwitchChannel $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
}