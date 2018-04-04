<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 16:07
 */

namespace AppBundle\Model\TwitchApi;


class TwitchTeam
{
    /**
     * @var integer
     */
    private $_id;
    /**
     * @var string
     */
    private $background;
    /**
     * @var string
     */
    private $banner;
    /**
     * @var \DateTime
     */
    private $created_at;
    /**
     * @var string
     */
    private $display_name;
    /**
     * @var string
     */
    private $info;
    /**
     * @var string
     */
    private $logo;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setId($json['_id']);
        $this->setBackground($json['background']);
        $this->setBanner($json['banner']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setDisplayName($json['display_name']);
        $this->setInfo($json['info']);
        $this->setLogo($json['logo']);
        $this->setName($json['name']);
        $this->setUpdatedAt(new \DateTime($json['updated_at']));
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
     * @return TwitchTeam
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param string $background
     *
     * @return TwitchTeam
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param string $banner
     *
     * @return TwitchTeam
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

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
     * @return TwitchTeam
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

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
     * @return TwitchTeam
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $info
     *
     * @return TwitchTeam
     */
    public function setInfo($info)
    {
        $this->info = $info;

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
     * @return TwitchTeam
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

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
     * @return TwitchTeam
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return TwitchTeam
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}