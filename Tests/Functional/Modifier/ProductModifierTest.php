<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\MagentoConnectorBundle\Tests\Functional\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\MagentoConnectorBundle\Documents\CategoryObject;
use ONGR\MagentoConnectorBundle\Documents\ImageObject;
use ONGR\MagentoConnectorBundle\Documents\PriceObject;
use ONGR\MagentoConnectorBundle\Documents\ProductDocument;
use ONGR\MagentoConnectorBundle\Documents\UrlObject;
use ONGR\MagentoConnectorBundle\Modifier\ProductModifier;
use ONGR\MagentoConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if product modifier works as expected.
 */
class ProductModifierTest extends TestBase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        $shopId = 0;

        $expectedEntity1 = new ProductDocument();
        $expectedEntity1->setId(231);
        $expectedEntity1->setSku('msj000');
        $expectedEntity1->setTitle('French Cuff Cotton Twill Oxford');
        $expectedEntity1->setDescription('Button front. Long sleeves. Tapered collar, chest pocket, french cuffs.');
        $expectedEntity1->setExpiredUrls([]);
        $url = new UrlObject();
        $url->setUrl('french-cuff-cotton-twill-oxford.html');
        $expectedEntity1->addUrlObject($url);
        $image = new ImageObject();
        $image->setUrl('/m/s/msj000t_1.jpg');
        $expectedEntity1->addImage($image);
        $smallImage = new ImageObject();
        $smallImage->setUrl('/m/s/msj000t_1.jpg');
        $expectedEntity1->addSmallImage($smallImage);
        $priceObject = new PriceObject(190.0);
        $expectedEntity1->setPrices([$priceObject]);
        $category = new CategoryObject();
        $category->setId(15);
        $category->setTitle('Shirts');
        $category->setPath('5/15');
        $url = new UrlObject();
        $url->setUrl('men/shirts.html');
        $category->setUrl($url);
        $category->setCategories(['5', '15']);
        $expectedEntity1->setCategories([$category]);
        $expectedEntity1->setLongDescription(
            'Made with wrinkle resistant cotton twill, this French-cuffed luxury' .
            ' dress shirt is perfect for Business Class frequent flyers.'
        );

        $expectedEntity2 = new ProductDocument();
        $expectedEntity2->setId(232);
        $expectedEntity2->setSku('msj001');
        $expectedEntity2->setTitle('French Cuff Cotton Twill Oxford');
        $expectedEntity2->setDescription('Button front. Long sleeves. Tapered collar, chest pocket, french cuffs.');
        $expectedEntity2->addPrice(new PriceObject(190));
        $expectedEntity2->setExpiredUrls([]);
        $expectedEntity2->addUrl('french-cuff-cotton-twill-oxford-563.html');
        $expectedEntity2->addSmallImageUrl('/m/s/msj000t_1.jpg');
        $expectedEntity2->addImageUrl('/m/s/msj000t_1.jpg');
        $category = new CategoryObject();
        $category->setId(15);
        $category->setTitle('Shirts');
        $category->setPath('5/15');
        $category->setUrlString('men/shirts.html');
        $category->addCategory('5');
        $category->addCategory('15');
        $expectedEntity2->addCategory($category);
        $expectedEntity2->setLongDescription(
            'Made with wrinkle resistant cotton twill, this French-cuffed luxury' .
            ' dress shirt is perfect for Business Class frequent flyers.'
        );

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        $productItems = $this->getTestElements(
            [231, 232],
            'ONGRMagentoConnectorBundleTest:CatalogProductEntity'
        );
        $this->assertCount(2, $productItems);

        $modifier = new ProductModifier($shopId);
        $createdProducts = [];

        foreach ($productItems as $productItem) {
            $createdProduct = new ProductDocument();
            $item = new ImportItem($productItem, $createdProduct);
            $event = new ItemPipelineEvent($item);
            $modifier->onModify($event);
            $createdProducts[] = $createdProduct;
        }

        $this->assertEquals($expectedEntities, $createdProducts);
    }
}
