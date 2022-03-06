# PHP-Serial

[![GitHub license](https://img.shields.io/github/license/fawno/PHP-Serial)](https://github.com/fawno/PHP-serial/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/fawno/PHP-Serial)](https://github.com/fawno/PHP-serial/releases)
[![Packagist](https://img.shields.io/packagist/v/fawno/php-serial)](https://packagist.org/packages/fawno/php-serial)
[![PHP](https://img.shields.io/packagist/php-v/fawno/php-serial)](https://php.net)

Serial port access convenience class

## Requirements
- PHP Pecl dio extension (>= 0.2.1) for SerialDio.

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
  use Fawno\PhpSerial\SerialConfig;
  use Fawno\PhpSerial\SerialBaudRates;
  use Fawno\PhpSerial\SerialStopBits;
  use Fawno\PhpSerial\SerialParity;
  use Fawno\PhpSerial\SerialDataBits;

  // Create default serial config
  $config = new SerialConfig;

  // Set Data Rate
  $config->setBaudRate(SerialBaudRates::B9600);

  // Set Data Bits
  $config->setDataBits(SerialDataBits::CS8);

  // Set Stop Bits
  $config->setStopBits(SerialStopBits::ONE);

  // Set Parity
  $config->setParity(SerialParity::NONE);

  // Set Flow Control
  $config->setFlowControl(true);

  // Create SerialDio object with COM3 as device
  $serial = new SerialDio('COM3', $config);

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
