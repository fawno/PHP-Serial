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

  use Fawno\PhpSerial\SerialException;
  use Fawno\PhpSerial\SerialConfig;

  /**
   * Serial provides general methods for serial communication.
   *
	 * @package Fawno\PhpSerial
   * @uses Fawno\PhpSerial\SerialException Provides custom exception
   * @used-by Fawno\PhpSerial\SerialDio
   * @used-by Fawno\PhpSerial\File\Darwing
   * @used-by Fawno\PhpSerial\File\Linux
   * @used-by Fawno\PhpSerial\File\Windows
   */
  class Serial {
    public const SERIAL_CANONICAL = [0, 1];

    protected $_serial = null;
    protected $_device = null;
    protected array $_options = [];

    /**
     * Construct the serial interface. Sets the device path and register shutdown function.
     *
     * @param string|null $device
     * @return void
     */
    public function __construct (string $device, SerialConfig $config) {
      $this->_device = $device;
      $this->_options = $config->__toArray();

      register_shutdown_function([$this, 'close']);
    }

    /**
     * Sets blocking/non-blocking mode
     *
     * @param bool $enable
     * If mode is FALSE, the given stream will be switched to non-blocking mode, and if TRUE, it will be switched to blocking mode. This affects calls like fgets and fread that read from the stream. In non-blocking mode an fgets call will always return right away while in blocking mode it will wait for data to become available on the stream.
     *
     * @return Serial
     * @throws SerialException
     */
    public function setBlocking (bool $enable) : Serial {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to set blocking');
      }

      if (!stream_set_blocking($this->_serial, $enable)) {
        throw new SerialException('Setting blocking error');
      }

      return $this;
    }

    /**
     * Sets timeout period
     *
     * @param int $seconds
     * The seconds part of the timeout to be set.
     *
     * @param int $microseconds
     * The microseconds part of the timeout to be set.
     *
     * @return Serial
     * @throws SerialException
     */
    public function setTimeout (int $seconds = 0, int $microseconds = 0) : Serial {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to set timeout');
      }

      if (!stream_set_timeout($this->_serial, $seconds, $microseconds)) {
        throw new SerialException('Setting timeout error');
      }

      return $this;
    }

    /**
     * Binds a named resource, specified by setDevice, to a stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as `fopen()`).
     *
     * @return void
     * @throws SerialException
     */
    public function open (string $mode = 'r+b') {
      if (is_resource($this->_serial)) {
        throw new SerialException('The device is already opened');
      }

      if (empty($this->_device)) {
        throw new SerialException('The device must be set before to be open');
      }

      if (!preg_match('~^[raw]\+?b?$~', $mode)) {
        throw new SerialException(sprintf('Invalid opening mode: %s. Use fopen() modes.', $mode));
      }
    }

    /**
     * Closes the serial stream.
     *
     * @return void
     * @throws SerialException
     */
    public function close () {
      if (is_resource($this->_serial)) {
        if (!fclose($this->_serial)) {
          throw new SerialException(sprintf('Unable to close the device %s', $this->_device));
        }
      }

      $this->_serial = null;
    }

    /**
     * Writes data to the serial stream.
     *
     * @param string $data
     * The written data.
     *
     * @return int|false
     * Returns the number of bytes written, or `false` on error.
     *
     * @throws SerialException
     */
    public function send (string $data) {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to write it');
      }

      return fwrite($this->_serial, $data);
    }

    /**
     * Reads remainder of the serial stream into a string.
     *
     * @param int $length
     * The maximum bytes to read. Defaults to -1 (read all the remainingbuffer).
     *
     * @param int $offset
     * Seek to the specified offset before reading. If this number is negative,no seeking will occur and reading will start from the current position.
     *
     * @return string|false
     * Returns a string or `false` on failure.
     *
     * @throws SerialException
     */
    public function read (int $length = -1, int $offset = -1) {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to read it');
      }

      return stream_get_contents($this->_serial, $length, $offset);
    }
  }
