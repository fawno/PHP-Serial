<?php
  declare(strict_types=1);

  namespace Fawno\PhpSerial\Config;

  use ReflectionClass;

  class StopBits {
    //public const NONE = 0;
    public const ONE = 1;
    public const TWO = 2;

    static function getConstants () : array {
      return (new ReflectionClass(__CLASS__))->getConstants();
    }

    static function checkValue (int $const) : bool {
      return in_array($const, self::getConstants());
    }
  }
