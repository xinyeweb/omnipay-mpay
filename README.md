yii2-mpay
=========
yii2-mpay

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xinyeweb/omnipay-mpay "*"
```

or add

```
"xinyeweb/omnipay-mpay": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \Omnipay\MPay\AutoloadExample::widget(); ?>```