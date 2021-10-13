<?php
  namespace Fawno\PhpSerial;

  use \ErrorException;
  use Fawno\PhpSerial\Serial;

  /**
   * @package Fawno\PhpSerial
   *
  */
  class SerialDio extends Serial {
    protected $_options = [
      'data_rate' => 9600,
      'data_bits' => 8,
      'stop_bits' => 1,
      'parity' => 0,
      'flow_control' => 1,
      'is_canonical' => 1,
    ];

    /**
     * Sets the canonical option of serial port.
     *
     * @param int $canonical
     * Can be 0 or 1. Default value is 1.
     *
     * @return void
     * @throws ErrorException
     */
    public function setCanonical (int $canonical = 1) {
      if (!in_array($canonical, self::SERIAL_CANONICAL)) {
        throw new ErrorException(sprintf('invalid flow_control value (%d)', $canonical), 0, E_USER_WARNING);
      }

      $this->_options['is_canonical'] = $canonical;
    }

    /**
     * Binds a named resource, specified by setDevice, to a stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as *fopen()*).
     *
     * @return void
     * @throws ErrorException
     */
    public function open (string $mode = 'r+b') {
      parent::open($mode);

      error_clear_last();
      $this->_serial = @dio_serial($this->_device, $mode, $this->_options);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        $error = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        throw new ErrorException(sprintf('Unable to open the device %s', $this->_device), 0, E_USER_WARNING, $error);
      }
    }

    /**
     * Binds a named resource, specified by setDevice, to a raw stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as *fopen()*).
     *
     * @return void
     * @throws ErrorException
     */
    public function open_raw (string $mode = 'r+b') {
      parent::open($mode);

      error_clear_last();
      $this->_serial = @dio_raw($this->_device, $mode, $this->_options);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        $error = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        throw new ErrorException(sprintf('Unable to open the device %s', $this->_device), 0, E_USER_WARNING, $error);
      }
    }
  }
