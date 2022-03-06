<?php
  declare(strict_types=1);

  namespace Fawno\PhpSerial;

  use Fawno\PhpSerial\SerialException;
  use Fawno\PhpSerial\SerialBaudRates;
  use Fawno\PhpSerial\SerialStopBits;
  use Fawno\PhpSerial\SerialParity;
  use Fawno\PhpSerial\SerialDataBits;

  class SerialConfig {
    protected int $data_rate    = SerialBaudRates::B9600;
    protected int $data_bits    = SerialDataBits::CS8;
    protected int $stop_bits    = SerialStopBits::ONE;
    protected int $parity       = SerialParity::NONE;
    protected int $flow_control = 1;
    protected int $is_canonical = 1;

    /**
     * Sets the data rate.
     *
     * @param int $data_rate
     * @return SerialConfig
     * @throws SerialException
     */
    public function setBaudRate (int $data_rate) {
      if (!SerialBaudRates::checkValue($data_rate)) {
        throw new SerialException(sprintf('Invalid data_rate value (%d)', $data_rate));
      }

      $this->data_rate = $data_rate;
      return $this;
    }

    /**
     * Sets the number of data bits.
     *
     * @param int $data_bits
     * @return SerialConfig
     * @throws SerialException
     */
    public function setDataBits (int $data_bits) {
      if (!SerialDataBits::checkValue($data_bits)) {
        throw new SerialException(sprintf('Invalid data_bits value (%d)', $data_bits));
      }

      $this->data_bits = $data_bits;
      return $this;
    }

    /**
     * Sets the number of stop bits.
     *
     * @param int $stop_bits
     * @return SerialConfig
     * @throws SerialException
     */
    public function setStopBits (int $stop_bits) {
      if (!SerialStopBits::checkValue($stop_bits)) {
        throw new SerialException(sprintf('Invalid stop_bits value (%d)', $stop_bits));
      }

      $this->stop_bits = $stop_bits;
      return $this;
    }

    /**
     * Sets the parity.
     *
     * @param int $parity
     * @return SerialConfig
     * @throws SerialException
     */
    public function setParity (int $parity) {
      if (!SerialParity::checkValue($parity)) {
        throw new SerialException(sprintf('Invalid parity value (%d)', $parity));
      }

      $this->parity = $parity;
      return $this;
    }

    /**
     * Sets the flow control.
     *
     * @param bool $flow_control
     * @return SerialConfig
     * @throws SerialException
     */
    public function setFlowControl (bool $flow_control) {
      if (!is_bool($flow_control)) {
        throw new SerialException(sprintf('Invalid flow_control value (%d)', $flow_control));
      }

      $this->flow_control = $flow_control ? 1 : 0;
      return $this;
    }

    /**
     * Sets the canonical option of serial port.
     *
     * @param bool $canonical
     *
     * @return SerialConfig
     * @throws SerialException
     */
    public function setCanonical (bool $canonical) {
      if (!is_bool($canonical)) {
        throw new SerialException(sprintf('Invalid canonical value (%d)', $canonical));
      }

      $this->is_canonical = $canonical ? 1 : 0;
    }

    public function __toArray () : array {
      return [
        'data_rate'    => $this->data_rate,
        'data_bits'    => $this->data_bits,
        'stop_bits'    => $this->stop_bits,
        'parity'       => $this->parity,
        'flow_control' => $this->flow_control,
        'is_canonical' => $this->is_canonical,
      ];
    }
  }
