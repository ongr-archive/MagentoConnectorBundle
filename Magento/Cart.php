<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\MagentoConnectorBundle\Magento;

use ONGR\ElasticsearchBundle\DSL\Filter\IdsFilter;
use ONGR\ElasticsearchBundle\DSL\Search;
use ONGR\ElasticsearchBundle\ORM\Manager;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\MagentoConnectorBundle\Document\ProductDocument;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handles the cart.
 */
class Cart extends AbstractMagentoSync implements \Countable
{
    /**
     * Name of the cookie where cart data is saved.
     */
    const CART_DATA_COOKIE_NAME = 'ongr_cart';

    /**
     * Parameter name for syncing with magento.
     */
    const CART_DATA_SYNC_PARAM_NAME = 'OngrProducts';

    /**
     * Parameter name for error list.
     */
    const CART_ERROR_LIST_PARAM_NAME = 'e';

    /**
     * Path to cart checkout in magento.
     */
    const CHECKOUT_PATH = '/checkout';

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var array
     */
    private $cartContent;

    /**
     * @var string
     */
    private $repositoryName;

    /**
     * @return string
     */
    public function getCheckoutUrl()
    {
        return $this->getMagentoUrl() . self::CHECKOUT_PATH;
    }

    /**
     * Constructs request to update cart in magento.
     *
     * @return RedirectResponse
     */
    public function getUpdateResponse()
    {
        $url = $this->getMagentoUrl() . '?'
            . http_build_query(
                [
                    self::CART_DATA_SYNC_PARAM_NAME => $this->getCartContent(),
                    self::MAGENTO_RETURN_URL_PARAM_NAME => $this->getReturnUrl(),
                ]
            );

        return new RedirectResponse($url);
    }

    /**
     * Url magento should redirect to after adding products.
     *
     * @return string
     */
    private function getReturnUrl()
    {
        return $this->getRouter()->generate('ongr_cart', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @param array $ids
     *
     * @return DocumentIterator
     */
    private function getDocumentsByIds($ids)
    {
        $search = new Search();
        $search->addFilter(new IdsFilter($ids));
        /** @var DocumentIterator $results */
        $results = $this->getManager()->getRepository($this->getRepositoryName())->execute($search);

        return $results;
    }

    /**
     * Gets documents of cart products.
     *
     * @return array
     */
    public function getCartDocuments()
    {
        $cartContents = $this->getCartContent();
        $contentDocuments = $this->getDocumentsByIds(array_keys($cartContents));

        $documents = [];
        /** @var ProductDocument $document */
        foreach ($contentDocuments as $key => $document) {
            $documents[] = ['document' => $document, 'quantity' => $cartContents[$document->getId()]];
        }

        return $documents;
    }

    /**
     * Gets documents for products that where not added to cart.
     *
     * @return ProductDocument[]|DocumentIterator
     */
    public function getErrorDocuments()
    {
        $request = $this->getRequestStack()->getCurrentRequest();
        $list = $request->query->get(self::CART_ERROR_LIST_PARAM_NAME);
        if ($list) {
            return $this->getDocumentsByIds($list);
        } else {
            return [];
        }
    }

    /**
     * @return array
     */
    public function getCartContent()
    {
        if ($this->cartContent === null) {
            $request = $this->getRequestStack()->getCurrentRequest();
            $content = json_decode($request->cookies->get(self::CART_DATA_COOKIE_NAME, '[]'), true);
            $this->cartContent = $this->cleanContent($content);
        }

        return $this->cartContent;
    }

    /**
     * Ensures contents are valid by removing invalid data.
     *
     * @param mixed $content
     *
     * @return array
     */
    private function cleanContent($content)
    {
        if (!is_array($content)) {
            return [];
        }

        foreach ($content as $id => $quantity) {
            if (!is_numeric($quantity)) {
                unset($content[$id]);
            }
        }

        return $content;
    }

    /**
     * @param array $cartContent
     *
     * @return $this
     */
    public function setCartContent($cartContent)
    {
        $this->cartContent = $cartContent;

        return $this;
    }

    /**
     * Adds product to cart.
     *
     * @param int|string $id
     * @param int        $quantity
     *
     * @return $this
     */
    public function addProduct($id, $quantity = 1)
    {
        $content = $this->getCartContent();

        if (isset($content[$id])) {
            $content[$id] += $quantity;
        } else {
            $content[$id] = $quantity;
        }

        $this->setCartContent($content);

        return $this;
    }

    /**
     * Removes product from cart.
     *
     * @param int|string $id
     *
     * @return $this
     */
    public function removeProduct($id)
    {
        $content = $this->getCartContent();

        if (isset($content[$id])) {
            unset($content[$id]);
            $this->setCartContent($content);
        }

        return $this;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     *
     * @return $this
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return UrlGeneratorInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param UrlGeneratorInterface $router
     *
     * @return $this
     */
    public function setRouter(UrlGeneratorInterface $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->getCartContent());
    }

    /**
     * Returns product repository name.
     *
     * @return string
     */
    public function getRepositoryName()
    {
        return $this->repositoryName;
    }

    /**
     * Sets product repository name.
     *
     * @param string $repositoryName
     *
     * @return $this
     */
    public function setRepositoryName($repositoryName)
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }
}
