<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 17:32
 */

namespace AppBundle\Model\TwitchApi;


class TwitchEmoticonImage
{
    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $emoticon_set;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setWidth($json['width']);
        $this->setHeight($json['height']);
        $this->setUrl($json['url']);
        $this->setEmoticonSet($json['emoticon_set']);
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return TwitchEmoticonImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return TwitchEmoticonImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

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
     * @return TwitchEmoticonImage
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return int
     */
    public function getEmoticonSet()
    {
        return $this->emoticon_set;
    }

    /**
     * @param int $emoticon_set
     *
     * @return TwitchEmoticonImage
     */
    public function setEmoticonSet($emoticon_set)
    {
        $this->emoticon_set = $emoticon_set;

        return $this;
    }
}