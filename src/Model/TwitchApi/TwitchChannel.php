<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 13:42
 */

namespace AppBundle\Model\TwitchApi;


class TwitchChannel
{
    /**
     * @var boolean
     */
    private $mature;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $broadcaster_language;

    /**
     * @var string
     */
    private $display_name;

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
    private $_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var boolean
     */
    private $partner;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $video_banner;

    /**
     * @var string
     */
    private $profile_banner;

    /**
     * @var string
     */
    private $profile_banner_background_color;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $views;

    /**
     * @var integer
     */
    private $followers;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setMature($json['mature']);
        $this->setStatus($json['status']);
        $this->setBroadcasterLanguage($json['broadcaster_language']);
        $this->setDisplayName($json['display_name']);
        $this->setGame($json['game']);
        $this->setLanguage($json['language']);
        $this->setId($json['_id']);
        $this->setName($json['name']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setUpdatedAt(new \DateTime($json['updated_at']));
        $this->setPartner($json['partner']);
        $this->setLogo($json['logo']);
        $this->setVideoBanner($json['video_banner']);
        $this->setProfileBanner($json['profile_banner']);
        $this->setProfileBannerBackgroundColor($json['profile_banner_background_color']);
        $this->setUrl($json['url']);
        $this->setViews($json['views']);
        $this->setFollowers($json['followers']);
    }

    /**
     * @return bool
     */
    public function isMature()
    {
        return $this->mature;
    }

    /**
     * @param bool $mature
     *
     * @return TwitchChannel
     */
    public function setMature($mature)
    {
        $this->mature = $mature;

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
     * @return TwitchChannel
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getBroadcasterLanguage()
    {
        return $this->broadcaster_language;
    }

    /**
     * @param string $broadcaster_language
     *
     * @return TwitchChannel
     */
    public function setBroadcasterLanguage($broadcaster_language)
    {
        $this->broadcaster_language = $broadcaster_language;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     *
     * @return TwitchChannel
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

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
     * @return TwitchChannel
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
     * @return TwitchChannel
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
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
     * @return TwitchChannel
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return TwitchChannel
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return TwitchChannel
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     *
     * @return TwitchChannel
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPartner()
    {
        return $this->partner;
    }

    /**
     * @param bool $partner
     *
     * @return TwitchChannel
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     *
     * @return TwitchChannel
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoBanner()
    {
        return $this->video_banner;
    }

    /**
     * @param string $video_banner
     *
     * @return TwitchChannel
     */
    public function setVideoBanner($video_banner)
    {
        $this->video_banner = $video_banner;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfileBanner()
    {
        return $this->profile_banner;
    }

    /**
     * @param string $profile_banner
     *
     * @return TwitchChannel
     */
    public function setProfileBanner($profile_banner)
    {
        $this->profile_banner = $profile_banner;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfileBannerBackgroundColor()
    {
        return $this->profile_banner_background_color;
    }

    /**
     * @param string $profile_banner_background_color
     *
     * @return TwitchChannel
     */
    public function setProfileBannerBackgroundColor($profile_banner_background_color)
    {
        $this->profile_banner_background_color = $profile_banner_background_color;

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
     * @return TwitchChannel
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
     * @return TwitchChannel
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return int
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param int $followers
     *
     * @return TwitchChannel
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;

        return $this;
    }
}