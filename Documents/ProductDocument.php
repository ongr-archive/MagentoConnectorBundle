<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Documents;

use ONGR\ContentBundle\Document\Traits\ProductTrait;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * Product document.
 *
 * @ES\Document
 */
class ProductDocument implements DocumentInterface
{
    use DocumentTrait;
    use ProductTrait;

    /**
     * Structure that represents possible URLs for the model.
     *
     * Eg.:
     *
     * <code>
     * array(
     *     array('url' => 'foo/'),
     *     array('url' => 'bar/', 'key' => 'bar_url'),
     * )
     * </code>
     *
     * @var UrlObject[]|\Iterator
     *
     * @ES\Property(name="url", type="object", objectName="MagentoConnectorBundle:UrlObject", multiple=true)
     */
    private $url;

    /**
     * @var string[] Array of expired url hashes.
     *
     * @ES\Property(name="expired_url", type="string")
     */
    private $expiredUrl;

    /**
     * @var ImagesNested[]|\Iterator
     *
     * @ES\Property(name="images", type="nested", objectName="MagentoConnectorBundle:ImagesNested", multiple=true)
     */
    private $images;

    /**
     * @var ImagesNested[]|\Iterator
     *
     * @ES\Property(name="small_images", type="nested", objectName="MagentoConnectorBundle:ImagesNested", multiple=true)
     */
    private $smallImages;

    /**
     * @var CategoryObject[]|\Iterator
     *
     * @ES\Property(name="categories", type="object", objectName="MagentoConnectorBundle:CategoryObject", multiple=true)
     */
    private $categories;

    /**
     * @var PriceObject[]|\Iterator
     *
     * @ES\Property(name="prices", type="object", objectName="MagentoConnectorBundle:PriceObject", multiple=true)
     */
    private $prices;

    /**
     * @return \string[]
     */
    public function getExpiredUrl()
    {
        return $this->expiredUrl;
    }

    /**
     * @param \string[] $expiredUrl
     */
    public function setExpiredUrl($expiredUrl)
    {
        $this->expiredUrl = $expiredUrl;
    }

    /**
     * @param string $expiredUrl
     */
    public function addExpiredUrl($expiredUrl)
    {
        $this->expiredUrl[] = $expiredUrl;
    }

    /**
     * @return \Iterator|UrlObject[]
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param \Iterator|UrlObject[] $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param UrlObject $urlObject
     */
    public function addUrlObject($urlObject)
    {
        $this->url[] = $urlObject;
    }

    /**
     * @param string $urlString
     */
    public function addUrl($urlString)
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl($urlString);
        $this->url[] = $urlObject;
    }

    /**
     * @return \Iterator|CategoryObject[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \Iterator|CategoryObject[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param CategoryObject $categoryObject
     */
    public function addCategory($categoryObject)
    {
        $this->categories[] = $categoryObject;
    }

    /**
     * @return \Iterator|ImagesNested[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Iterator|ImagesNested[] $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @param ImagesNested $imageObject
     */
    public function addImage($imageObject)
    {
        $this->images[] = $imageObject;
    }

    /**
     * @param string $imageUrl
     */
    public function addImageUrl($imageUrl)
    {
        $imageObject = new ImagesNested();
        $imageObject->setUrl($imageUrl);
        $this->images[] = $imageObject;
    }

    /**
     * @return \Iterator|ImagesNested[]
     */
    public function getSmallImages()
    {
        return $this->smallImages;
    }

    /**
     * @param \Iterator|ImagesNested[] $smallImages
     */
    public function setSmallImages($smallImages)
    {
        $this->smallImages = $smallImages;
    }

    /**
     * @param string $imageUrl
     */
    public function addSmallImageUrl($imageUrl)
    {
        $imageObject = new ImagesNested();
        $imageObject->setUrl($imageUrl);
        $this->smallImages[] = $imageObject;
    }

    /**
     * @return \Iterator|PriceObject[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param \Iterator|PriceObject[] $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @param PriceObject $price
     */
    public function addPrice($price)
    {
        $this->prices[] = $price;
    }
}
