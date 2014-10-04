Speckcommerce Cart module
=========================

Installation
------------

1.  Require speckcommerce/speck-cart:

    ```sh
    composer.phar require speckcommerce/assetmanager
    #when asked for a version, type "develop".
    ```

Post installation
------------------

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'Speckcommerce\Cart',
        ),
        // ...
    );
    ```
2. Make sure db adapter for doctrine is configured then run from application root:

    ```sh
    vendor/bin/doctrine-module orm:schema-tool:create
    ```

TODO
----

- Update README with detailed installation instructions
- Add DomanEvents
- Move Doctrine annotations on entities to xml or similar
