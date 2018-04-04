<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 12:55
 */

namespace AppBundle\Model\TwitchApi;


class TwitchUser
{
    /**
     * @var string
     */
    private $display_name;

    /**
     * @var integer
     */
    private $_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $bio;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var string
     */
    private $logo;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setDisplayName($json['display_name']);
        $this->setId($json['_id']);
        $this->setName($json['name']);
        $this->setType($json['type']);
        $this->setBio($json['bio']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setUpdatedAt(new \DateTime($json['updated_at']));
        $this->setLogo($json['logo']);
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
     * @return TwitchUser
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

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
     * @return TwitchUser
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
     * @return TwitchUser
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return TwitchUser
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     *
     * @return TwitchUser
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

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
     * @return TwitchUser
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
     * @return TwitchUser
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

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
     * @return TwitchUser
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }
}