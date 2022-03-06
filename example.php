<?php
  declare(strict_types=1);

  require __DIR__ . '/autoload.php';

  use Fawno\PhpSerial\SerialBaudRates;
  use Fawno\PhpSerial\SerialConfig;
  use Fawno\PhpSerial\SerialStopBits;
  use Fawno\PhpSerial\SerialParity;
  use Fawno\PhpSerial\SerialDataBits;
  use Fawno\PhpSerial\SerialDio;

  $config = new SerialConfig;
  $config->setBaudRate(SerialBaudRates::B9600);
  $config->setDataBits(SerialDataBits::CS8);
  $config->setStopBits(SerialStopBits::ONE);
  $config->setParity(SerialParity::NONE);
  $config->setFlowControl(true);

  $serial = new SerialDio('COM4', $config);
  $serial->open('r+b');
  $serial->setBlocking(false);
  $serial->setTimeout(0, 100000);

  $serial->send('at+ver' . "\r\n");

  $data = $serial->read();

  echo $data;
