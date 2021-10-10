# PHP-Serial

[![GitHub license](https://img.shields.io/github/license/fawno/PHP-Serial)](https://github.com/fawno/PHP-serial/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/fawno/PHP-Serial)](https://github.com/fawno/PHP-serial/releases)
[![Packagist](https://img.shields.io/packagist/v/fawno/php-serial)](https://packagist.org/packages/fawno/php-serial)
[![PHP](https://img.shields.io/packagist/php-v/fawno/php-serial)](https://php.net)

 Serial port access convenience class

## Requirements
 - PHP Pecl dio extension (>= 0.0.2) for SerialDio.

## Installation

You can install this plugin into your application using
[composer](https://getcomposer.org):

```
  composer require fawno/php-serial
```

## Usage

```php
  require 'vendor/autoload.php';

  use Fawno\PhpSerial\SerialDio;

  // Create SerialDio object with COM3 as device
	$serial = new SerialDio('COM3');

	// Set device
	$serial->SetDevice('COM4');

	// Set Data Rate
	$serial->setDataRate(9600);

	// Set Parity
	$serial->setParity(0);

	// Set Data Bits
	$serial->setDataBits(8);

	// Set Stop Bits
	$serial->setStopBits(1);

	// Set Flow Control
	$serial->setFlowControl(0);

	// Open device
	$serial->open('r+b');

	// Set Blocking
	$serial->setBlocking(0);

	// Set Timeout
	$serial->setTimeout(0, 0);

	// Send data
	$serial->send($data);

	// Read data
	$data = $serial->read();
```
