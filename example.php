<?php
  require __DIR__ . '/autoload.php';

  use Fawno\PhpSerial\SerialDio;

  $serial = new SerialDio('COM4');
  $serial->setDataRate(9600);
  $serial->setParity(0);
  $serial->setDataBits(8);
  $serial->setStopBits(1);
  $serial->setFlowControl(0);
  $serial->open('r+b');
  $serial->setBlocking(0);
  $serial->setTimeout(0, 100000);

  $serial->send('at+ver' . "\r\n");

  $data = $serial->read();

  echo $data;
