<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 15:08
 */

namespace AppBundle\Model\TwitchApi;


class TwitchFollower
{
    /**
     * @var \DateTime
     */
    private $created_at;
    /**
     * @var boolean
     */
    private $notifications;
    /**
     * @var TwitchUser
     */
    private $user;

    /**
     * @var TwitchChannel
     */
    private $channel;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setNotifications($json['notifications']);

        if (isset($json['user'])) {
            $user = new TwitchUser();
            $user->setDataByJson($json['user']);
            $this->setUser($user);
        }

        if (isset($json['channel'])) {
            $channel = new TwitchChannel();
            $channel->setDataByJson($json['channel']);
            $this->setChannel($channel);
        }
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
     * @return TwitchFollower
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param bool $notifications
     *
     * @return TwitchFollower
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * @return TwitchUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param TwitchUser $user
     *
     * @return TwitchFollower
     */
    public function setUser($user)
    {
        $this->user = $user;

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
     * @return TwitchFollower
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }
}