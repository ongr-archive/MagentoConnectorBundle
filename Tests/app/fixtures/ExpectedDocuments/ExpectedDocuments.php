<?php
/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\MagentoConnectorBundle\Tests\app\fixtures\ExpectedDocuments;

use ONGR\MagentoConnectorBundle\Document\CategoryObject;
use ONGR\MagentoConnectorBundle\Document\CdnObject;
use ONGR\MagentoConnectorBundle\Document\ImageObject;
use ONGR\MagentoConnectorBundle\Document\PriceObject;
use ONGR\MagentoConnectorBundle\Document\UrlObject;
use ONGR\MagentoConnectorBundle\Tests\app\fixtures\MagentoTestBundle\Document\Product;

/**
 * This class return tests documents.
 */
class ExpectedDocuments
{
    /**
     * Return test Products array.
     *
     * @return array
     */
    public static function getProductDocument()
    {
        return [
            [
                'urls' => [['url' => 'french-cuff-cotton-twill-oxford-563.html']],
                'images' => [['url' => '/m/s/msj000t_1.jpg']],
                'small_images' => [['url' => '/m/s/msj000t_1.jpg']],
                'categories' => [
                    [
                        'id' => 15,
                        'title' => 'Shirts',
                        'url' => ['url' => 'men/shirts.html'],
                        'path' => '5/15',
                        'categories' => ['5', '15'],
                    ],
                ],
                'prices' => [
                    ['price' => 190],
                ],
                'short_description' =>
                    'Made with wrinkle resistant cotton twill, this French-cuffed luxury' .
                    ' dress shirt is perfect for Business Class frequent flyers.',
                'title' => 'French Cuff Cotton Twill Oxford',
                'description' => 'Button front. Long sleeves. Tapered collar, chest pocket, french cuffs.',
                'sku' => 'msj001',
            ],
            [
                'urls' => [['url' => 'plaid-cotton-shirt.html']],
                'images' => [['url' => '/m/s/msj006t_1.jpg']],
                'small_images' => [['url' => '/m/s/msj006t_1.jpg']],
                'categories' => [
                    [
                        'id' => 15,
                        'title' => 'Shirts',
                        'url' => ['url' => 'men/shirts.html'],
                        'path' => '5/15',
                        'categories' => ['5', '15'],
                    ],
                ],
                'prices' => [
                    ['price' => 160],
                ],
                'short_description' => 'This everyday shirt is equally stylish with jeans or trousers.',
                'title' => 'Plaid Cotton Shirt',
                'description' =>
                    'Available in Sharp fit. Refined collar. Button cuff. ' .
                    'Cotton. Machine wash. Made in US.',
                'sku' => 'msj006',
            ],
            [
                'urls' => [['url' => 'linen-blazer-578.html']],
                'images' => [['url' => '/m/s/msj012t_1.jpg']],
                'small_images' => [['url' => '/m/s/msj012t_1.jpg']],
                'categories' => [
                    [
                        'id' => 40,
                        'title' => 'Blazers',
                        'url' => ['url' => 'men/blazers.html'],
                        'path' => '5/40',
                        'categories' => ['5', '40'],
                    ],
                ],
                'prices' => [
                    ['price' => 455],
                ],
                'short_description' =>
                    'In airy lightweight linen, this blazer is classic tailoring with a warm weather twist.',
                'title' => 'Linen Blazer',
                'description' =>
                    'Single vented, notched lapels. Flap pockets. Tonal stitching. Fully lined. Linen. Dry clean.',
                'sku' => 'msj013',
            ],
            [
                'urls' => [['url' => 'chelsea-tee.html']],
                'images' => [['url' => '/m/t/mtk000t_3.jpg']],
                'small_images' => [['url' => '/m/t/mtk000t_3.jpg']],
                'categories' => [
                    [
                        'id' => 16,
                        'title' => 'Tees, Knits and Polos',
                        'url' => ['url' => 'men/tees-knits-and-polos.html'],
                        'path' => '5/16',
                        'categories' => ['5', '16'],
                    ],
                ],
                'prices' => [
                    ['price' => 75],
                ],
                'short_description' => 'Minimalist style and maximum comfort meet in this lightweight tee.',
                'title' => 'Chelsea Tee',
                'description' => 'Ultrasoft, lightweight V-neck tee. 100% cotton. Machine wash.',
                'sku' => 'mtk000',
            ],
            [
                'urls' => [['url' => 'chelsea-tee-697.html']],
                'images' => [['url' => '/m/t/mtk002t_3.jpg']],
                'small_images' => [['url' => '/m/t/mtk002t_3.jpg']],
                'categories' => [
                    [
                        'id' => 16,
                        'title' => 'Tees, Knits and Polos',
                        'url' => ['url' => 'men/tees-knits-and-polos.html'],
                        'path' => '5/16',
                        'categories' => ['5', '16'],
                    ],
                ],
                'prices' => [
                    ['price' => 75],
                ],
                'short_description' => 'Minimalist style and maximum comfort meet in this lightweight tee.',
                'title' => 'Chelsea Tee',
                'description' => 'Ultrasoft, lightweight V-neck tee. 100% cotton. Machine wash.',
                'sku' => 'mtk002',
            ],
            [
                'urls' => [['url' => 'merino-v-neck-pullover-sweater-554.html']],
                'images' => [['url' => '/m/t/mtk006t_2.jpg']],
                'small_images' => [['url' => '/m/t/mtk006t_2.jpg']],
                'categories' => [
                    [
                        'id' => 16,
                        'title' => 'Tees, Knits and Polos',
                        'url' => ['url' => 'men/tees-knits-and-polos.html'],
                        'path' => '5/16',
                        'categories' => ['5', '16'],
                    ],
                ],
                'prices' => [
                    ['price' => 210],
                ],
                'short_description' =>
                    'A classy V-neck sweater crafted from smooth refined Merino wool. ' .
                    'Essential for layering when changing climates.',
                'title' => 'Merino V-neck Pullover Sweater',
                'description' =>
                    'Long sleeve, pull over style. V-neck. Relaxed fit through the chest. ' .
                    'Ribbed neckline, cuff and hem. 100% Merino wool. Dry clean.',
                'sku' => 'mtk007',
            ],
            [
                'urls' => [['url' => 'core-striped-sport-shirt-546.html']],
                'images' => [['url' => '/m/t/mtk012t_1.jpg']],
                'small_images' => [['url' => '/m/t/mtk012t_1.jpg']],
                'categories' => [
                    [
                        'id' => 16,
                        'title' => 'Tees, Knits and Polos',
                        'url' => ['url' => 'men/tees-knits-and-polos.html'],
                        'path' => '5/16',
                        'categories' => ['5', '16'],
                    ],
                ],
                'prices' => [
                    ['price' => 125],
                ],
                'short_description' => 'This grommet closure sports shirt is wrinkle free straight from the dryer. ',
                'title' => 'Core Striped Sport Shirt',
                'description' =>
                    'Slim fit. Two chest pockets. Silver grommet detail. Grinding and nicking at hems. 100% cotton. ',
                'sku' => 'mtk014',
            ],
            [
                'urls' => [['url' => 'bowery-chino-pants-539.html']],
                'images' => [['url' => '/m/p/mpd003t_3.jpg']],
                'small_images' => [['url' => '/m/p/mpd003t_3.jpg']],
                'categories' => [
                    [
                        'id' => 17,
                        'title' => 'Pants & Denim',
                        'url' => ['url' => 'men/pants-denim.html'],
                        'path' => '5/17',
                        'categories' => ['5', '17'],
                    ],
                ],
                'prices' => [
                    ['price' => 140],
                ],
                'short_description' =>
                    "The slim and trim Bowery is a wear-to-work pant you'll actually want to wear. " .
                    "A clean style in our crisp, compact cotton twill, it's perfectly " .
                    'polished (but also comfortable enough for hanging out after hours).',
                'title' => 'Bowery Chino Pants',
                'description' =>
                    'Straight leg chino. Back pockets with button closure. 14" leg opening. Zip fly. 100% cotton.',
                'sku' => 'mpd004',
            ],
            [
                'urls' => [['url' => 'the-essential-boot-cut-jean.html']],
                'images' => [['url' => '/m/p/mpd006t_1.jpg']],
                'small_images' => [['url' => '/m/p/mpd006t_1.jpg']],
                'categories' => [
                    [
                        'id' => 17,
                        'title' => 'Pants & Denim',
                        'url' => ['url' => 'men/pants-denim.html'],
                        'path' => '5/17',
                        'categories' => ['5', '17'],
                    ],
                ],
                'prices' => [
                    ['price' => 140],
                ],
                'short_description' =>
                    'The new standard in denim, this jean is the rightful favorite among our designers. ' .
                    'Made from lightly distressed denim to achieve that perfectly broken-in feel.',
                'title' => 'The Essential Boot Cut Jean',
                'description' =>
                    'Lightly faded cotton denim. Sits below waist. Slim through hip and thigh. ' .
                    '15" leg opening. Zip fly. Machine wash. ',
                'sku' => 'mpd006',
            ],
            [
                'urls' => [['url' => 'the-essential-boot-cut-jean-540.html']],
                'images' => [['url' => '/m/p/mpd006t_1.jpg']],
                'small_images' => [['url' => '/m/p/mpd006t_1.jpg']],
                'categories' => [
                    [
                        'id' => 17,
                        'title' => 'Pants & Denim',
                        'url' => ['url' => 'men/pants-denim.html'],
                        'path' => '5/17',
                        'categories' => ['5', '17'],
                    ],
                ],
                'prices' => [
                    ['price' => 140],
                ],
                'short_description' =>
                    'The new standard in denim, this jean is the rightful favorite among our designers. ' .
                    'Made from lightly distressed denim to achieve that perfectly broken-in feel.',
                'title' => 'The Essential Boot Cut Jean',
                'description' =>
                    'Lightly faded cotton denim. Sits below waist. Slim through hip and thigh. ' .
                    '15" leg opening. Zip fly. Machine wash. ',
                'sku' => 'mpd011',
            ],
        ];
    }

    /**
     * Return test Category array.
     *
     * @return array
     */
    public static function getCategoryDocument()
    {
        return [
            [
                'urls' => [['url' => 'women.html']],
                'path' => '/4',
                'sort' => 2,
                'active' => true,
                'parent_id' => 'magentorootid',
                'title' => 'Women',
            ],
            [
                'urls' => [['url' => 'vip.html']],
                'path' => '/9',
                'sort' => 7,
                'active' => true,
                'parent_id' => 'magentorootid',
                'title' => 'VIP',
            ],
            [
                'urls' => [['url' => 'women/tops-blouses.html']],
                'path' => '/4/11',
                'sort' => 2,
                'active' => true,
                'parent_id' => 4,
                'title' => 'Tops & Blouses',
            ],
            [
                'urls' => [['url' => 'men/tees-knits-and-polos.html']],
                'path' => '/5/16',
                'sort' => 3,
                'active' => true,
                'parent_id' => 5,
                'title' => 'Tees, Knits and Polos',
            ],
            [
                'urls' => [['url' => 'home-decor/bed-bath.html']],
                'path' => '/7/23',
                'sort' => 2,
                'active' => true,
                'parent_id' => 7,
                'title' => 'Bed & Bath',
            ],
            [
                'urls' => [['url' => 'sale/accessories.html']],
                'path' => '/8/28',
                'sort' => 3,
                'active' => true,
                'parent_id' => 8,
                'title' => 'Accessories',
            ],
            [
                'urls' => [['url' => 'men.html']],
                'path' => '/5',
                'sort' => 3,
                'active' => true,
                'parent_id' => 'magentorootid',
                'title' => 'Men',
            ],
            [
                'urls' => [['url' => 'women/pants-denim.html']],
                'path' => '/4/12',
                'sort' => 3,
                'active' => true,
                'parent_id' => 4,
                'title' => 'Pants & Denim',
            ],
            [
                'urls' => [['url' => 'men/pants-denim.html']],
                'path' => '/5/17',
                'sort' => 4,
                'active' => true,
                'parent_id' => 5,
                'title' => 'Pants & Denim',
            ],
            [
                'urls' => [['url' => 'home-decor/electronics.html']],
                'path' => '/7/24',
                'sort' => 3,
                'active' => true,
                'parent_id' => 7,
                'title' => 'Electronics',
            ],
        ];
    }

    /**
     * Return test Content array.
     *
     * @return array
     */
    public static function getContentDocument()
    {
        return [
            [
                'slug' => 'customer-service',
                'title' => 'Customer Service',
                'content' => 'Customer Service content',
            ],
            [
                'heading' => 'Reward Points',
                'slug' => 'reward-points',
                'title' => 'Reward Points',
                'content' => '<p>The Reward Points Program allows you to earn points for certain actions you ' .
                    'take on the site.</p>',
            ],
            [
                'slug' => 'enable-cookies',
                'title' => 'Enable Cookies',
                'content' => '<div class="std">Enable Cookies</div>',
            ],
            [
                'slug' => 'no-route',
                'title' => '404 Not Found',
                'content' => '<p><img src="{{media url="wysiwyg/404-banner-3.jpg"}}" alt="404bannerimage" />',
            ],
            [
                'heading' => 'Privacy Policy',
                'slug' => 'privacy-policy-cookie-restriction-mode',
                'title' => 'Privacy Policy',
                'content' => 'Privacy Policy Content',
            ],
            [
                'slug' => 'home',
                'title' => 'Madison Island',
                'content' => '<div class="slideshow-container">Madison Island content</div>',
            ],
            [
                'slug' => 'service-unavailable',
                'title' => '503 Service Unavailable',
                'content' => '<p>service unavailable</p>',
            ],
            [
                'slug' => 'about-magento-demo-store',
                'title' => 'About Us',
                'content' => 'About us content',
            ],
            [
                'slug' => 'private-sales',
                'title' => 'Welcome to our Exclusive Online Store',
                'content' => '<h1>Welcome to our Exclusive Online Store</h1>',
            ],
            [
                'slug' => 'company',
                'title' => 'Company',
                'content' => '<div class="page-head"><h3>OUR STORY</h3></div>',
            ],
        ];
    }

    /**
     * Return expected urls objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return UrlObject[]
     */
    public static function getExpectedUrlsObjects($count, $from = 0)
    {
        $expectedAttributes = self::getCategoryDocument();

        foreach ($expectedAttributes as $key => $value) {
            $urlObject = new UrlObject();
            $urlObject->setUrl($value['urls'][0]['url']);
            $expectedUrls[] = $urlObject;
        }

        return array_slice($expectedUrls, $from, $count);
    }

    /**
     * Return expected urls array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return UrlObject[]
     */
    public static function getExpectedUrlsArray($count, $from = 0)
    {
        $expectedAttributes = self::getCategoryDocument();

        foreach ($expectedAttributes as $key => $value) {
            $expectedUrls[] = $value['urls'][0];
        }

        return array_slice($expectedUrls, $from, $count);
    }

    /**
     * Return expected category objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return CategoryObject[]
     */
    public static function getExpectedCategoryObject($count, $from = 0)
    {
        $expectedAttributes = self::getCategoryDocument();

        foreach ($expectedAttributes as $key => $value) {
            $categoryObject = new CategoryObject();
            $categoryObject->setId($key);
            $categoryObject->setTitle($value['title']);
            $categoryObject->setUrl($value['urls'][0]['url']);
            $categoryObject->setPath($value['path']);
            $categoryObject->setCategories([$value['parent_id']]);

            $expectedCategories[] = $categoryObject;
        }

        return array_slice($expectedCategories, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return ImageObject[]
     */
    public static function getExpectedImageObject($count, $from = 0)
    {
        $expectedAttributes = self::getProductDocument();

        foreach ($expectedAttributes as $key => $value) {
            $imageObject = new ImageObject();

            $imageObject->setUrl($value['images'][0]['url']);

            $expectedImages[] = $imageObject;
        }

        return array_slice($expectedImages, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return PriceObject[]
     */
    public static function getExpectedPriceObject($count, $from = 0)
    {
        $expectedAttributes = self::getProductDocument();

        foreach ($expectedAttributes as $key => $value) {
            $priceObject = new PriceObject(0.0);
            $priceObject->setPrice($value['prices'][0]['price']);
            $expectedPrices[] = $priceObject;
        }

        return array_slice($expectedPrices, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return string[]
     */
    public static function getExpectedDescriptionArray($count, $from = 0)
    {
        $expectedDescriptions = self::getExpectedStringArray('getProductDocument', 'title');

        return array_slice($expectedDescriptions, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return string[]
     */
    public static function getExpectedPathArray($count, $from = 0)
    {
        $expectedPaths = self::getExpectedStringArray('getCategoryDocument', 'path');

        return array_slice($expectedPaths, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $fromMethod
     * @param int $attribute
     *
     * @return string[]
     */
    public static function getExpectedStringArray($fromMethod, $attribute)
    {
        $attributes = self::$fromMethod();

        foreach ($attributes as $key => $value) {
            $expectedArrays[] = $value[$attribute];
        }

        return $expectedArrays;
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return string[]
     */
    public static function getExpectedTitleArray($count, $from = 0)
    {
        $expectedPaths = self::getExpectedStringArray('getCategoryDocument', 'title');

        return array_slice($expectedPaths, $from, $count);
    }

    /**
     * Return expected image objects array for testing.
     *
     * @param int $count
     * @param int $from
     *
     * @return string[]
     */
    public static function getExpectedIdArray($count, $from = 0)
    {
        $expectedPaths = self::getExpectedStringArray('getProductDocument', 'sku');

        return array_slice($expectedPaths, $from, $count);
    }
}
