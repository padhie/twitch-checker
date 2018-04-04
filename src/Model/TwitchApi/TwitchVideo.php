<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 19:24
 */

namespace AppBundle\Model\TwitchApi;


class TwitchVideo
{

    /**
     * @var integer
     */
    private $_id;

    /**
     * @var integer
     */
    private $broadcast_id;

    /**
     * @var string
     */
    private $broadcast_type;

    /**
     * @var TwitchChannel
     */
    private $channel;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $description_html;

    /**
     * @var array
     */
    private $fps;

    /**
     * @var string
     */
    private $game;

    /**
     * @var string
     */
    private $language;

    /**
     * @var integer
     */
    private $length;

    /**
     * @var array
     */
    private $muted_segments;

    /**
     * @var array
     */
    private $preview;

    /**
     * @var \DateTime
     */
    private $published_at;

    /**
     * @var array
     */
    private $resolutions;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $tag_list;

    /**
     * @var array
     */
    private $thubnails;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $viewable;

    /**
     * @var \DateTime
     */
    private $viewable_at;

    /**
     * @var integer
     */
    private $views;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setId($json['_id']);
        $this->setBroadcastId($json['broadcast_id']);
        $this->setBroadcastType($json['broadcast_type']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setDescription($json['description']);
        $this->setDescriptionHtml($json['description_html']);
        $this->setFps($json['fps']);
        $this->setGame($json['game']);
        $this->setLanguage($json['language']);
        $this->setLength($json['length']);
        $this->setMutedSegments($json['muted_segments']);
        $this->setPreview($json['preview']);
        $this->setPublishedAt(new \DateTime($json['published_at']));
        $this->setStatus($json['status']);
        $this->setTagList($json['tag_list']);
        $this->setThubnails($json['thumbnails']);
        $this->setTitle($json['title']);
        $this->setUrl($json['url']);
        $this->setViewable($json['viewable']);
        $this->setViewableAt(new \DateTime($json['viewable_at']));
        $this->setViews($json['views']);

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
     *
     * @return TwitchVideo
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getBroadcastId()
    {
        return $this->broadcast_id;
    }

    /**
     * @param int $broadcast_id
     *
     * @return TwitchVideo
     */
    public function setBroadcastId($broadcast_id)
    {
        $this->broadcast_id = $broadcast_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getBroadcastType()
    {
        return $this->broadcast_type;
    }

    /**
     * @param string $broadcast_type
     *
     * @return TwitchVideo
     */
    public function setBroadcastType($broadcast_type)
    {
        $this->broadcast_type = $broadcast_type;

        return $this;
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
     *
     * @return TwitchVideo
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
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
     *
     * @return TwitchVideo
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return TwitchVideo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml()
    {
        return $this->description_html;
    }

    /**
     * @param string $description_html
     *
     * @return TwitchVideo
     */
    public function setDescriptionHtml($description_html)
    {
        $this->description_html = $description_html;

        return $this;
    }

    /**
     * @return array
     */
    public function getFps()
    {
        return $this->fps;
    }

    /**
     * @param array $fps
     *
     * @return TwitchVideo
     */
    public function setFps($fps)
    {
        $this->fps = $fps;

        return $this;
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
     *
     * @return TwitchVideo
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return TwitchVideo
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     *
     * @return TwitchVideo
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return array
     */
    public function getMutedSegments()
    {
        return $this->muted_segments;
    }

    /**
     * @param array $muted_segments
     *
     * @return TwitchVideo
     */
    public function setMutedSegments($muted_segments)
    {
        $this->muted_segments = $muted_segments;

        return $this;
    }

    /**
     * @return array
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param array $preview
     *
     * @return TwitchVideo
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }

    /**
     * @param \DateTime $published_at
     *
     * @return TwitchVideo
     */
    public function setPublishedAt($published_at)
    {
        $this->published_at = $published_at;

        return $this;
    }

    /**
     * @return array
     */
    public function getResolutions()
    {
        return $this->resolutions;
    }

    /**
     * @param array $resolutions
     *
     * @return TwitchVideo
     */
    public function setResolutions($resolutions)
    {
        $this->resolutions = $resolutions;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return TwitchVideo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getTagList()
    {
        return $this->tag_list;
    }

    /**
     * @param string $tag_list
     *
     * @return TwitchVideo
     */
    public function setTagList($tag_list)
    {
        $this->tag_list = $tag_list;

        return $this;
    }

    /**
     * @return array
     */
    public function getThubnails()
    {
        return $this->thubnails;
    }

    /**
     * @param array $thubnails
     *
     * @return TwitchVideo
     */
    public function setThubnails($thubnails)
    {
        $this->thubnails = $thubnails;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return TwitchVideo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return TwitchVideo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getViewable()
    {
        return $this->viewable;
    }

    /**
     * @param string $viewable
     *
     * @return TwitchVideo
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getViewableAt()
    {
        return $this->viewable_at;
    }

    /**
     * @param \DateTime $viewable_at
     *
     * @return TwitchVideo
     */
    public function setViewableAt($viewable_at)
    {
        $this->viewable_at = $viewable_at;

        return $this;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     *
     * @return TwitchVideo
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }
}