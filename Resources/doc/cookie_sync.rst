Synchronizing Cart And Customer
===============================

Synchronizing from Magento to ONGR is done via cookies. After every action with cart (adding or removing products)
a cookie is set with all the products in cart. Also after login, logout and customer information update another cookie
is updated.

Synchronization from ONGR to Magento is done via requests. More detailed information about will come up later.

Setting up synchronization will require installing `MagentoSyncModule <https://github.com/ongr-io/MagentoSyncModule>`_
and a bit of configuration.

Step 1. Installing Magento Module
---------------------------------

Follow standard procedure for installing `Magento Sync Module <https://github.com/ongr-io/MagentoSyncModule>`_. Then,
if needed, set domain of ONGR project in ``system->configuration->ONGR SYNC->Sync Options``. This setting is used for
cookie domain and if left empty current domain will be used.

Step 2. Configuring MagentoConnectorBundle
------------------------------------------

This bundle has 2 services to handle the synchronization with magento and they require some configuration to work
properly.

In your config file under ``ongr_magento`` you will need to set ``url`` of Magento store, ``es_manager`` and
``product_repository``.

Example configuration:

.. code-block:: yaml

    ongr_magento:
        store_id: 0
        shop_id: 1
        url: http://magento.ongr.dev
        es_manager: magento
        product_repository: ONGRMagentoConnectorBundle:ProductDocument

..

Using the Customer service.
---------------------------

Customer service id is ``ongr_magento.sync.cart``. This service allows getting currently logged in customer information
and helps with login and logout functionality.

Login
~~~~~

Method ``getLoginUrl`` will give url to login page in Magento with back url parameter of current location so that user
is instantly redirected to back to ONGR project after successful login.

Logout
~~~~~~

Method ``getLogoutUrl`` will give url to logout page in magento with back url parameter of current location.
User will be instantly redirected back to current location after following this url.

Getting Customer Data
~~~~~~~~~~~~~~~~~~~~~

Method ``getUserData`` will fetch customer data from cookie to a ParameterBag. Default Magento installation will
provide with following fields:

* id
* website_id
* entity_id
* entity_type_id
* attribute_set_id
* email
* group_id
* increment_id
* store_id
* created_at
* updated_at
* is_active
* disable_auto_group_change
* created_in
* firstname
* lastname
* default_billing
* default_shipping

Using the Cart service.
-----------------------

Customer service id is ``ongr_magento.sync.cart``. This service allows adding, removing and viewing products in cart.

Manipulating products
~~~~~~~~~~~~~~~~~~~~~

Service holds products in associative array where key is product id and value is quantity. Contents can be set directly
with ``setCartContent`` method or added with ``addProduct`` method and removed with ``removeProduct`` method.
After updating cart you will need to sync cart with Magento, in order to do that
``getUpdateResponse`` method can be used. It will generate a redirect response to the magento with cart data then
Magento after adding products will redirect to ``ongr_cart`` route.

Magento will add list of products that were not and that list can be accessed by ``getErrorDocuments`` method.

Also ``getCheckoutUrl`` method will return url for checking out product in magento.

Displaying products
~~~~~~~~~~~~~~~~~~~

Method ``getCartDocuments`` will get an array of product documents and quantities which can be used
for displaying purposes. Returned array format:

.. code-block:: php

    [
        ['document' => $document1, 'quantity' => $quantity1],
        ['document' => $document2, 'quantity' => $quantity2],
        ...
    ]

..

Example actions
---------------

.. code-block:: php

    /**
     * Displays cart contents.
     *
     * @Route("/cart")
     */
    public function cartAction()
    {
        return $this->render(
            'AcmeMagentoBundle::cart:html.twig',
            [
                'cart' => $this->getCart()->getCartDocuments(),
                'error' => $this->getCart()->getErrorDocuments(),
                'checkoutUrl' => $this->getCart()->getCheckoutUrl(),
            ]
        );
    }

..

.. code-block:: php

    /**
     * Adds product to cart and syncs cart with magento.
     *
     * @Route("/cart/add/{id}/{quantity}", defaults={"quantity" : 1})
     */
    public function addAction($id, $quantity)
    {
        return $this->getCart()->addProduct($id, $quantity)->getUpdateResponse();
    }

..

.. code-block:: php

    /**
     * Display user block.
     *
     * @Route("/customer")
     */
    public function customerAction()
    {
        return $this->render(
            'AcmeMagentoBundle::cart:html.twig',
            [
                'userData' => $this->getCustomer()->getUserData(),
                'cartCount' => count($this->getCart()),
                'logoutUrl' => $this->getCustomer()->getLogoutUrl(),
                'loginUrl' => $this->getCustomer()->getLoginUrl(),
            ]
        );
    }

..
