<?php
/**
 * Created by PhpStorm.
 * User: Hinata Ryokan
 * Date: 20.01.2018
 * Time: 17:25
 */

namespace AppBundle\Model\TwitchApi;


class TwitchEmoticon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $regex;

    /**
     * @var TwitchEmoticonImage[]
     */
    private $images;


    /**
     * @param array $json
     */
    public function setDataByJson($json)
    {
        $this->setId($json['id']);
        $this->setRegex($json['regex']);

        foreach ($json['images'] AS $imageData) {
            $image = new TwitchEmoticonImage();
            $image->setDataByJson($imageData);
            $this->addImage($image);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return TwitchEmoticon
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @param string $regex
     *
     * @return TwitchEmoticon
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * @return TwitchEmoticonImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param TwitchEmoticonImage[] $images
     *
     * @return TwitchEmoticon
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param TwitchEmoticonImage $image
     *
     * @return TwitchEmoticon
     */
    public function addImage($image) {
        $this->images[] = $image;

        return $this;
    }
}