<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 13.02.2018
 * Time: 12:55
 */

namespace AppBundle\Model\TwitchApi;


class TwitchHost
{
    /**
     * @var TwitchChannel
     */
    private $channel;

    /**
     * @var TwitchChannel
     */
    private $target;

    /**
     * @var integer
     */
    private $viewer = 0;

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
     * @return TwitchHost
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return TwitchChannel
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param TwitchChannel $target
     *
     * @return TwitchHost
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return int
     */
    public function getViewer()
    {
        return $this->viewer;
    }

    /**
     * @param int $viewer
     *
     * @return TwitchHost
     */
    public function setViewer($viewer)
    {
        $this->viewer = $viewer;

        return $this;
    }
}