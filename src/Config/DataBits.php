<?php
  declare(strict_types=1);

  namespace Fawno\PhpSerial\Config;

  use ReflectionClass;

  class DataBits {
    //public const CS4 = 4; //win
    public const CS5 = 5;
    public const CS6 = 6;
    public const CS7 = 7;
    public const CS8 = 8;

    static function getConstants () : array {
      return (new ReflectionClass(__CLASS__))->getConstants();
    }

    static function checkValue (int $const) : bool {
      return in_array($const, self::getConstants());
    }
  }
