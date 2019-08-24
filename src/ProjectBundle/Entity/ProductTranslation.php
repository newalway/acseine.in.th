<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="product_translation", indexes={@ORM\Index(name="search_idx", columns={"title"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ProductTranslation
{
	use ORMBehaviors\Translatable\Translation;

	/**
	* @var string
	*
	* @ORM\Column(type="string", length=255)
	*/
	private $title;

	/**
    * @var string
    *
    * @ORM\Column(name="sub_title", type="string", length=255, nullable = true)
    */
    private $subTitle;

	/**
	* @var string
	*
	* @ORM\Column(name="short_desc", type="text", length=65535, nullable = true)
	*/
	private $shortDesc;

	/**
	* @var string
	*
	* @ORM\Column(type="text", length=65535, nullable = true)
	*/
	private $description;

	/**
	* @var string
	*
	* @ORM\Column(name="how_to_use", type="text", length=65535, nullable = true)
	*/
	private $howToUse;

	/**
	* @var string
	*
	* @ORM\Column(name="ingredient", type="text", length=65535, nullable = true)
	*/
	private $ingredient;

	/**
    * @var string
    *
    * @ORM\Column(name="meta_title", type="string", length=255, nullable = true)
    */
    private $metaTitle;

	/**
    * @var string
    *
    * @ORM\Column(name="meta_description", type="string", length=255, nullable = true)
    */
    private $metaDescription;

	/**
    * @var string
    *
    * @ORM\Column(name="meta_keywords", type="string", length=255, nullable = true)
    */
    private $metaKeywords;

	/**
	* Get the value of Title
	*
	* @return string
	*/
	public function getTitle()
	{
		return $this->title;
	}

    /**
     * Set the value of Title
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Short Desc
     *
     * @return string
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * Set the value of Short Desc
     *
     * @param string shortDesc
     *
     * @return self
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    /**
     * Get the value of Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param string description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of How To Use
     *
     * @return string
     */
    public function getHowToUse()
    {
        return $this->howToUse;
    }

    /**
     * Set the value of How To Use
     *
     * @param string howToUse
     *
     * @return self
     */
    public function setHowToUse($howToUse)
    {
        $this->howToUse = $howToUse;

        return $this;
    }

    /**
     * Get the value of Ingredient
     *
     * @return string
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set the value of Ingredient
     *
     * @param string ingredient
     *
     * @return self
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }


    /**
     * Get the value of Sub Title
     *
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set the value of Sub Title
     *
     * @param string subTitle
     *
     * @return self
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

	/**
     * Get the value of Meta Title
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set the value of Meta Title
     *
     * @param string metaTitle
     *
     * @return self
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get the value of Meta Description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set the value of Meta Description
     *
     * @param string metaDescription
     *
     * @return self
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get the value of Meta Keywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set the value of Meta Keywords
     *
     * @param string metaKeywords
     *
     * @return self
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

}
