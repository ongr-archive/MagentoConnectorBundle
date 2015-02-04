===========
Quick start
===========

Let's get started. We'll guide you step by step through installing and running ``ONGR sandbox`` integration with ``Magento`` for
the first time. The first installation should not need more than 1.5 hours.

Step 1: Requirements.
---------------------

Yes, there are a few.

Please check if your development environment satisfies minimum requirements in our handbook.

Step 2: Download ONGR
---------------------

Download the latest release from `our archive <https://github.com/ongr-io/ongr-sandbox/releases>`_ and unpack it somewhere under your project directory.
Make sure that we have the "Vagrantfile" in the your project root folder.

Checkout branch ``magento``

Step 3: Install Virtual Box
---------------------------

Either install or upgrade `virtualbox <https://www.virtualbox.org/wiki/Downloads>`_. We need VirtualBox > 4.3

Step 4: Install Vagrant
-----------------------

Either install or upgrade `vagrant <https://www.vagrantup.com/downloads.html>`_. We need Vagrant >= 1.6.5

    (optional) Now we can install the hosts updater vagrant plugin.

.. code-block:: bash

    vagrant plugin install vagrant-hostsupdater

..

   It will help to automatically update /etc/hosts file via adding your new ongr.dev host with correct IP.

And finally - ``ONLY FOR LINUX`` you need to install the nfs server:

.. code-block:: bash

    sudo apt-get install nfs-kernel-server

..

Step 5: Start virtual machine using Vagrant
-------------------------------------------

Let's rock. Move into your project root folder and execute:

.. code-block:: bash

    vagrant up

..

In case you have also something like VMWare installed on your local machine, it is a good idea to give the provider when upping your box:

.. code-block:: bash

    vagrant up --provider=virtualbox

..


That's it. The ONGR is alive.

If you experience any problems (e.g. vagrant tends to change the rules with each update and we might lag a bit) please do not hesitate to contact us. We'll help.

Now, let's feed the donkey with some data.

Step 6: Install Magento with the demo data
------------------------------------------

In case to get Magento and its demo content you need to take a following steps:

.. code-block:: bash

    vagrant ssh
    cd /var/www
    composer install --no-interaction

..

   NOTE: If composer prompts input questions just press enter.


Then run magento install script (be patient, it takes some time):

.. code-block:: bash

    cd store
    ./magento.sh

..

After Magento installation is complete, clear Magento cache:

.. code-block:: bash

    rm -r ./magento/var/cache/                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  ./magento.sh

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

Step 7: Sync
-------------------------


If you wish to check how data sync, between Magento and ONGR databases works, you should make a change in Magento admin and run following commands:

.. code-block:: bash

    app/console ongr:sync:storage:create --shop-id=0 mysql
    app/console ongr:sync:provide:parameter last_sync_date --set="2014-02-19 00:00:00"
    app/console ongr:sync:provide magento

    app/console ongr:sync:execute magento.product
    app/console ongr:sync:execute magento.category

..
