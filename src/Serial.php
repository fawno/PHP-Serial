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
  namespace Fawno\PhpSerial;

  use Fawno\PhpSerial\SerialException;

  /**
   * Serial provides general methods for serial communication.
   *
	 * @package Fawno\PhpSerial
   * @uses Fawno\PhpSerial\SerialException Provides custom exception
   * @used-by Fawno\PhpSerial\SerialDio
   * @used-by Fawno\PhpSerial\SerialFileDarwing
   * @used-by Fawno\PhpSerial\SerialFileLinux
   * @used-by Fawno\PhpSerial\SerialFileWindows
   */
  class Serial {
    public const SERIAL_DATA_RATES = [75, 110, 134, 150, 300, 600, 1200, 1800, 2400, 4800, 7200, 9600, 14400, 19200, 38400, 57600, 115200, 56000, 128000, 256000];
    public const SERIAL_DATA_BITS = [8, 7, 6, 5];
    public const SERIAL_STOP_BITS = [1, 2];
    public const SERIAL_PARITY = [0, 1, 2];
    public const SERIAL_FLOW_CONTROL = [0, 1];
    public const SERIAL_CANONICAL = [0, 1];

    protected $_serial = null;
    protected $_device = null;
    protected $_options = [
      'data_rate' => 9600,
      'data_bits' => 8,
      'stop_bits' => 1,
      'parity' => 0,
      'flow_control' => 1,
    ];

    /**
     * Construct the serial interface. Sets the device path and register shutdown function.
     *
     * @param string|null $device
     * @return void
     */
    public function __construct (string $device = null) {
      $this->setDevice($device);

      register_shutdown_function([$this, 'close']);
    }

    /**
     * Sets the device path.
     *
     * @param string|null $device
     * @return void
     */
    public function setDevice (string $device = null) {
      $this->_device = $device;
    }

    /**
     * Sets the data rate.
     *
     * @param int $data_rate
     * @return void
     * @throws SerialException
     */
    public function setDataRate (int $data_rate = 9600) {
      if (!in_array($data_rate, self::SERIAL_DATA_RATES)) {
        throw new SerialException(sprintf('Invalid data_rate value (%d)', $data_rate));
      }

      $this->_options['data_rate'] = $data_rate;
    }

    /**
     * Sets the parity.
     *
     * @param int $parity
     * @return void
     * @throws SerialException
     */
    public function setParity (int $parity = 0) {
      if (!in_array($parity, self::SERIAL_PARITY)) {
        throw new SerialException(sprintf('Invalid parity value (%d)', $parity));
      }

      $this->_options['parity'] = $parity;
    }

    /**
     * Sets the number of data bits.
     *
     * @param int $data_bits
     * @return void
     * @throws SerialException
     */
    public function setDataBits (int $data_bits = 8) {
      if (!in_array($data_bits, self::SERIAL_DATA_BITS)) {
        throw new SerialException(sprintf('Invalid data_bits value (%d)', $data_bits));
      }

      $this->_options['data_bits'] = $data_bits;
    }

    /**
     * Sets the number of stop bits.
     *
     * @param int $stop_bits
     * @return void
     * @throws SerialException
     */
    public function setStopBits (int $stop_bits = 1) {
      if (!in_array($stop_bits, self::SERIAL_STOP_BITS)) {
        throw new SerialException(sprintf('Invalid stop_bits value (%d)', $stop_bits));
      }

      $this->_options['stop_bits'] = $stop_bits;
    }

    /**
     * Sets the flow control.
     *
     * @param int $flow_control
     * @return void
     * @throws ErrorSerialException
     */
    public function setFlowControl (int $flow_control = 1) {
      if (!in_array($flow_control, self::SERIAL_FLOW_CONTROL)) {
        throw new SerialException(sprintf('Invalid flow_control value (%d)', $flow_control));
      }

      $this->_options['flow_control'] = $flow_control;
    }

    /**
     * Sets blocking/non-blocking mode
     *
     * @param bool $enable
     * If mode is FALSE, the given stream will be switched to non-blocking mode, and if TRUE, it will be switched to blocking mode. This affects calls like fgets and fread that read from the stream. In non-blocking mode an fgets call will always return right away while in blocking mode it will wait for data to become available on the stream.
     *
     * @return bool
     * true on success or false on failure.
     *
     * @throws SerialException
     */
    public function setBlocking (bool $enable) : bool {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to set blocking');
      }

      return stream_set_blocking($this->_serial, $enable);
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
     * @return bool
     * true on success or false on failure.
     *
     * @throws SerialException
     */
    public function setTimeout (int $seconds = 0, int $microseconds = 0) : bool {
      if (!is_resource($this->_serial)) {
        throw new SerialException('Device must be opened to set timeout');
      }

      return stream_set_timeout($this->_serial, $seconds, $microseconds);
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
          throw new SerialException('Unable to close the device');
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
