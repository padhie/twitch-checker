<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 15:11
 */

namespace AppBundle\Model\TwitchApi;


class TwitchSubscription
{
    /**
     * @var integer
     */
    private $_id;
    /**
     * @var \DateTime
     */
    private $created_at;
    /**
     * @var string
     */
    private $sub_plan;
    /**
     * @var string
     */
    private $sub_plan_name;

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
        $this->setId($json['_id']);
        $this->setCreatedAt(new \DateTime($json['created_at']));
        $this->setSubPlan($json['sub_plan']);
        $this->setSubPlanName($json['sub_plan_name']);

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
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     *
     * @return TwitchSubscription
     */
    public function setId($id)
    {
        $this->_id = $id;

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
     * @return TwitchSubscription
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubPlan()
    {
        return $this->sub_plan;
    }

    /**
     * @param string $sub_plan
     *
     * @return TwitchSubscription
     */
    public function setSubPlan($sub_plan)
    {
        $this->sub_plan = $sub_plan;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubPlanName()
    {
        return $this->sub_plan_name;
    }

    /**
     * @param string $sub_plan_name
     *
     * @return TwitchSubscription
     */
    public function setSubPlanName($sub_plan_name)
    {
        $this->sub_plan_name = $sub_plan_name;

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
     * @return TwitchSubscription
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
     * @return TwitchSubscription
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }
}