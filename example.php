<?php
  declare(strict_types=1);

  require __DIR__ . '/autoload.php';

  use Fawno\PhpSerial\Config\BaudRates;
  use Fawno\PhpSerial\Config\StopBits;
  use Fawno\PhpSerial\Config\Parity;
  use Fawno\PhpSerial\Config\DataBits;
  use Fawno\PhpSerial\SerialConfig;
  use Fawno\PhpSerial\SerialDio;

  $config = new SerialConfig;
  $config->setBaudRate(BaudRates::B9600);
  $config->setDataBits(DataBits::CS8);
  $config->setStopBits(StopBits::ONE);
  $config->setParity(Parity::NONE);
  $config->setFlowControl(true);

  $serial = new SerialDio('COM4', $config);
  $serial->open('r+b');
  $serial->setBlocking(false);
  $serial->setTimeout(0, 100000);

  $serial->send('at+ver' . "\r\n");

  $data = $serial->read();

  echo $data;
