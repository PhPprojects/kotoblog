<?php

namespace Kotoblog\Entity;

use Kotoblog\Entity\SlugAbleInterface;
use Kotoblog\Entity\SortableInterface;

/**
 * Article
 */
class Article implements SlugAbleInterface, SortableInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $textSource;

    /**
     * @var boolean
     */
    private $publish;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tags;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Article
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     *
     * @return Article
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return boolean 
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setTags($tags)
    {
        $lowWeightTags = is_array($tags) ? array_diff($this->tags->toArray(), $tags) : $this->tags;

        /** @var Tag $tag */
        foreach ($lowWeightTags as $tag) {
            $tag->decrementWeight();
        }

        if (is_array($tags)) {
            $highWeightTags = array_diff($tags, $this->tags->toArray());

            foreach ($highWeightTags as $tag) {
                $tag->incrementWeight();
            }
        }

        $this->tags = $tags;

        return $this;
    }

    /**
     * Add tags
     *
     * @param \Kotoblog\Entity\Tag $tag
     * @return Article
     */
    public function addTag(\Kotoblog\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
        $tag->incrementWeight();

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Kotoblog\Entity\Tag $tag
     * @return $this
     */
    public function removeTag(\Kotoblog\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
        $tag->decrementWeight();

        return $this;
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }
    /**
     * @var integer
     */
    private $weight;


    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Article
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    public static function getPreferredSorting()
    {
        return self::LATEST;
    }

    /**
     * @return string
     */
    public function getTextSource()
    {
        return $this->textSource;
    }

    /**
     * @param string $textSource
     * @return $this
     */
    public function setTextSource($textSource)
    {
        $this->textSource = $textSource;

        return $this;
    }
}
