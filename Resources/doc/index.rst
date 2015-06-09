===========
Quick start
===========

Let's get started. We'll guide you step by step through installing and running ``ONGR sandbox`` integration with ``Magento`` for
the first time. The first installation should not need more than 1.5 hours.

First 5 installation steps are same as in :doc:`/components/ongr-sandbox/index`.

.. warning::
    After completing steps 1 - 5 in ongr-sandbox quick start manual, come back here to do steps 6 - 8.

Step 6: Install Magento with the demo data
------------------------------------------

In case to get Magento and its demo content you need to take a following steps:

.. code-block:: bash

    vagrant ssh
    cd /var/www
    composer install --no-interaction

..

.. note::
    If composer prompts input questions just press enter.


Then run magento install script (be patient, it takes some time):

.. code-block:: bash

    cd store
    ./magento.sh

..

Now you must create new index for ElasticSearch:

.. code-block:: bash

    cd ..
    app/console es:index:create

..

And import demo content for `ongr.dev <http://ongr.dev>`_ pages:

.. code-block:: bash

    app/console es:index:import --raw src/ONGR/DemoBundle/Resources/data/contents.json

..

Now you need to import data from magento to your newly baked ONGR shop:

.. code-block:: bash

    app/console ongr:import:full magento.product
    app/console ongr:import:full magento.category

..

Step 7: Open your browser
-------------------------

Navigate your browser to `http://ongr.dev <http://ongr.dev/>`_

Here you will find your new shops front end.


If you visit `http://magento.ongr.dev/ <http://magento.ongr.dev/>`_  you will find original Magento e-shop with demo data.

If you wish to check Magento administrators UI go to `http://magento.ongr.dev/admin <http://magento.ongr.dev/admin>`_

    Username: admin

    Password: admin123

Step 8: Sync
------------


If you wish to check how data sync, between Magento and ONGR databases works, you should make a change in Magento admin and run following commands:

.. code-block:: bash

    app/console ongr:sync:storage:create --shop-id=0 mysql
    app/console ongr:sync:provide:parameter last_sync_date --set="2014-02-19 00:00:00"
    app/console ongr:sync:provide magento

    app/console ongr:sync:execute magento.product
    app/console ongr:sync:execute magento.category

..

.. toctree::
    :maxdepth: 1
    :titlesonly:
    :glob:

    *

..
