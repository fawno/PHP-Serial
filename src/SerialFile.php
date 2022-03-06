<?php
  /**
   * PHP-Serial: Serial port access convenience class (https://github.com/fawno/PHP-serial)
   * Copyright (c) Fernando Herrero (https://github.com/alpha)
   *
   * Licensed under The MIT License
   * For full copyright and license information, please see the LICENSE
   * Redistributions of files must retain the above copyright notice.
   *
   * @copyright     Fernando Herrero (https://github.com/alpha)
   * @link          https://github.com/fawno/PHP-serial PHP-Serial
   * @since         0.1.0
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */
  namespace Fawno\PhpSerial;

  use Fawno\PhpSerial\SerialException;
  use Fawno\PhpSerial\SerialConfig;
  use Fawno\PhpSerial\SerialFileWindows;
  use Fawno\PhpSerial\SerialFileLinux;
  use Fawno\PhpSerial\SerialFileDarwing;

  $sysName = php_uname();
  $osName = preg_replace('~^.*(Linux|Darwing|Windows).*$~', '$1', $sysName);
  $classFile = __DIR__ . '/SerialFile' . $osName . '.php';

  if (is_file($classFile)) {
    include $classFile;
  }

  if (!class_exists('Fawno\PhpSerial\SerialFile' . $osName)) {
    throw new SerialException(sprintf('Host OS "%s" is unsupported', $osName));
  }

  switch ($osName) {
    case 'Windows':
      {
        /**
         * SerialFile class provides serial connection using file stream.
         * Is a wrapper for specific OS class.
         *
         * @package Fawno\PhpSerial
         * @uses Fawno\PhpSerial\SerialFileWindows Provides serial connection using file stream in Windows OS
         * @uses Fawno\PhpSerial\SerialException
         */
        class SerialFile extends SerialFileWindows {
          /**
           * Construct the serial interface. Sets the device path and register shutdown function.
           *
           * @param string|null $device
           * @return void
           */
          public function __construct (string $device = null, SerialConfig $config) {
            parent::__construct($device, $config);
            unset($this->_options['is_canonical']);
          }
        }
      }
      break;
    case 'Linux':
      {
        /**
         * SerialFile class provides serial connection using file stream.
         * Is a wrapper for specific OS class.
         *
         * @package Fawno\PhpSerial
         * @uses Fawno\PhpSerial\SerialFileLinux Provides serial connection using file stream in Linux OS
         * @uses Fawno\PhpSerial\SerialException
         */
        class SerialFile extends SerialFileLinux {
          /**
           * Construct the serial interface. Sets the device path and register shutdown function.
           *
           * @param string|null $device
           * @return void
           */
          public function __construct (string $device = null, SerialConfig $config) {
            parent::__construct($device, $config);
            unset($this->_options['is_canonical']);
          }
        }
      }
      break;
    case 'Darwing':
      {
        /**
         * SerialFile class provides serial connection using file stream.
         * Is a wrapper for specific OS class.
         *
         * @package Fawno\PhpSerial
         * @uses Fawno\PhpSerial\SerialFileDarwing Provides serial connection using file stream in OSX OS
         * @uses Fawno\PhpSerial\SerialException
         */
        class SerialFile extends SerialFileDarwing {
          /**
           * Construct the serial interface. Sets the device path and register shutdown function.
           *
           * @param string|null $device
           * @return void
           */
          public function __construct (string $device = null, SerialConfig $config) {
            parent::__construct($device, $config);
            unset($this->_options['is_canonical']);
          }
        }
      }
      break;
  }
