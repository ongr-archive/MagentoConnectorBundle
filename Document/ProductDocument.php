<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Document;

use ONGR\ContentBundle\Document\Traits\ProductTrait;
use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;
use ONGR\MagentoConnectorBundle\Helpers\GetterSetterHelperTrait;

/**
 * ElasticSearch Product document.
 *
 * @ES\Document(type="product")
 */
class ProductDocument implements DocumentInterface
{
    use DocumentTrait;
    use ProductTrait;
    use GetterSetterHelperTrait;

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
     * @ES\Property(name="urls", type="object", objectName="ONGRMagentoConnectorBundle:UrlObject", multiple=true)
     */
    private $urls;

    /**
     * @var string[] Array of expired urls hashes.
     *
     * @ES\Property(name="expired_urls", type="string", multiple=true)
     */
    private $expiredUrls;

    /**
     * @var ImageObject[]|\Iterator
     *
     * @ES\Property(name="images", type="object", objectName="ONGRMagentoConnectorBundle:ImageObject", multiple=true)
     */
    private $images;

    /**
     * @var ImageObject[]|\Iterator
     *
     * @ES\Property(
     *      name="small_images",
     *      type="object",
     *      objectName="ONGRMagentoConnectorBundle:ImageObject",
     *      multiple=true
     * )
     */
    private $smallImages;

    /**
     * @var CategoryObject[]|\Iterator
     *
     * @ES\Property(
     *      name="categories",
     *      type="object",
     *      objectName="ONGRMagentoConnectorBundle:CategoryObject",
     *      multiple=true
     * )
     */
    private $categories;

    /**
     * @var PriceObject[]|\Iterator
     *
     * @ES\Property(name="prices", type="object", objectName="ONGRMagentoConnectorBundle:PriceObject", multiple=true)
     */
    private $prices;

    /**
     * @var string
     *
     * @ES\Property(name="short_description", type="string")
     */
    private $shortDescription;

    /**
     * @return string[]
     */
    public function getExpiredUrls()
    {
        return $this->expiredUrls;
    }

    /**
     * @param string[] $expiredUrls
     */
    public function setExpiredUrls($expiredUrls)
    {
        $this->expiredUrls = $expiredUrls;
    }

    /**
     * @param string $expiredUrl
     */
    public function addExpiredUrl($expiredUrl)
    {
        $this->expiredUrls[] = $expiredUrl;
    }

    /**
     * Remove expired url from array.
     *
     * @param string $expiredUrl
     */
    public function removeExpiredUrl($expiredUrl)
    {
        $this->removeElement($expiredUrl, $this->expiredUrls);
    }

    /**
     * @return \Iterator|UrlObject[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param \Iterator|UrlObject[] $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }

    /**
     * @param UrlObject $urlObject
     */
    public function addUrl($urlObject)
    {
        $this->urls[] = $urlObject;
    }

    /**
     * Remove url from array.
     *
     * @param UrlObject $urlObject
     */
    public function removeUrl($urlObject)
    {
        $this->removeElement($urlObject, $this->urls);
    }

    /**
     * @param string $urlString
     */
    public function addUrlString($urlString)
    {
        $urlObject = new UrlObject();
        $urlObject->setUrl($urlString);
        $this->urls[] = $urlObject;
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
     * Remove Category from array.
     *
     * @param CategoryObject $categoryObject
     */
    public function removeCategory($categoryObject)
    {
        $this->removeElement($categoryObject, $this->categories);
    }

    /**
     * @return \Iterator|ImageObject[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \Iterator|ImageObject[] $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @param ImageObject $imageObject
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
        $imageObject = new ImageObject();
        $imageObject->setUrl($imageUrl);
        $this->images[] = $imageObject;
    }

    /**
     * @return \Iterator|ImageObject[]
     */
    public function getSmallImages()
    {
        return $this->smallImages;
    }

    /**
     * @param \Iterator|ImageObject[] $smallImages
     */
    public function setSmallImages($smallImages)
    {
        $this->smallImages = $smallImages;
    }

    /**
     * @param ImageObject $smallImage
     */
    public function addSmallImage($smallImage)
    {
        $this->smallImages[] = $smallImage;
    }

    /**
     * @param string $imageUrl
     */
    public function addSmallImageUrl($imageUrl)
    {
        $imageObject = new ImageObject();
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

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }
}
