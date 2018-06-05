Config consul adapter
===========
[![License](https://poser.pugx.org/leaphly/cart-bundle/license.svg)](https://packagist.org/packages/leaphly/cart-bundle)
[![Build Status](https://travis-ci.org/Kachit/config-consul.svg?branch=master)](https://travis-ci.org/Kachit/config-consul)
[![Latest Stable Version](https://poser.pugx.org/kachit/config-consul/v/stable)](https://packagist.org/packages/kachit/config-consul)
[![Total Downloads](https://poser.pugx.org/kachit/config-consul/downloads)](https://packagist.org/packages/kachit/config-consul)

Config consul adapter

```php
<?php
$sf = new SensioLabs\Consul\ServiceFactory(['base_uri' => 'http://consul.service.local']);
$kv = $sf->get('kv');

$reader = new Kachit\Config\Consul\Reader($kv);
$data = $reader->read('foo/bar/qwerty');
```
