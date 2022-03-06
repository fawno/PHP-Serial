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
   * @since         0.0.1
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */
  declare(strict_types=1);

  namespace Fawno\PhpSerial;

  use Fawno\PhpSerial\Serial;
  use Fawno\PhpSerial\SerialException;

  /**
   * SerialDio class provides serial connection using php-dio extension
   *
   * @package Fawno\PhpSerial
   * @uses Fawno\PhpSerial\Serial Provides general serial methods
   * @uses Fawno\PhpSerial\SerialException Provides custom exception
   * @used-by Fawno\PhpSerial\SerialFile
   */
  class SerialDio extends Serial {
    /**
     * Binds a named resource, specified by setDevice, to a stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as `fopen()`).
     *
     * @return SerialDio
     * @throws SerialException
     */
    public function open (string $mode = 'r+b') : SerialDio {
      parent::open($mode);

      error_clear_last();
      $this->_serial = @dio_serial($this->_device, $mode, $this->_options);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        if (is_array($error)) {
          $error = new SerialException($error['message'], 0, $error['type'], $error['file'], $error['line']);
          throw new SerialException(sprintf('Unable to open the device %s', $this->_device), 0, E_ERROR, null, null, $error);
        }

        throw new SerialException(sprintf('Unable to open the device %s', $this->_device));
      }

      return $this;
    }

    /**
     * Binds a named resource, specified by setDevice, to a raw stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as `fopen()`).
     *
     * @return SerialDio
     * @throws SerialException
     */
    public function open_raw (string $mode = 'r+b') : SerialDio {
      parent::open($mode);

      error_clear_last();
      $this->_serial = @dio_raw($this->_device, $mode, $this->_options);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        if (is_array($error)) {
          $error = new SerialException($error['message'], 0, $error['type'], $error['file'], $error['line']);
          throw new SerialException(sprintf('Unable to open the device %s', $this->_device), 0, E_ERROR, null, null, $error);
        }

        throw new SerialException(sprintf('Unable to open the device %s', $this->_device));
      }

      return $this;
    }
  }
