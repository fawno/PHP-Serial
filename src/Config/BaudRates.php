<?php
  declare(strict_types=1);

  namespace Fawno\PhpSerial\Config;

  use ReflectionClass;

  class BaudRates {
		//public const B50     =     50; //posix
		public const B75     =     75;
		public const B110    =    110;
		public const B134    =    134;
		public const B150    =    150;
		//public const B200    =    200; //posix
		public const B300    =    300;
		public const B600    =    600;
		public const B1200   =   1200;
		public const B1800   =   1800;
		public const B2400   =   2400;
		public const B4800   =   4800;
		//public const B7200   =   7200; //win
		public const B9600   =   9600;
		//public const B14400  =  14400; //win
		public const B19200  =  19200;
		public const B38400  =  38400;
		//public const B56000  =  56000; //win
		public const B57600  =  57600;
		public const B115200 = 115200;
		//public const B128000 = 128000; //win
		//public const B256000 = 256000; //win
		//public const B230400 = 230400; //posix
		//public const B460800 = 460800; //posix

    static function getConstants () : array {
      return (new ReflectionClass(__CLASS__))->getConstants();
    }

    static function checkValue (int $const) : bool {
      return in_array($const, self::getConstants());
    }
  }
