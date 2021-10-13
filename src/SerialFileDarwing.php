<?php
  namespace Fawno\PhpSerial;

  use Fawno\PhpSerial\Serial;
  use Fawno\PhpSerial\SerialException;

  /**
   * @package Fawno\PhpSerial
   *
  */
  class SerialFileDarwing extends Serial {
    /**
     * Set and prepare the port for conection.
     *
     * @return void
     * @throws SerialException
     */
    protected function setPortOptions () {
      $params = ['device' => $this->_device] + $this->_options;
      $param_formats = [
        'stop_bits' => [1 => '-cstopb', 2 => 'cstopb'],
        'parity' => [0 => '-parenb', 1 => 'parenb parodd', 2 => 'parenb -parodd'],
        'flow_control' => [0 => 'clocal -crtscts -ixon -ixoff', 1 => '-clocal -crtscts ixon ixoff'],
      ];

      foreach ($param_formats as $param => $values) {
        $params[$param] = $values[$params[$param]];
      }

      $command = 'stty -f %s %s cs%s %s %s %s';
      $command = sprintf($command, ...array_values($params));

      $message = exec($command, $output, $result_code);
      if ($result_code) {
        throw new SerialException(utf8_encode($message), $result_code);
      }
    }


    /**
     * Binds a named resource, specified by setDevice, to a stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as *fopen()*).
     *
     * @return void
     * @throws SerialException
     */
    public function open (string $mode = 'r+b') {
      $this->setPortOptions();

      parent::open($mode);

      error_clear_last();
      $this->_serial = @fopen($this->_device, $mode);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        if (is_array($error)) {
          $error = new SerialException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        }

        throw new SerialException(sprintf('Unable to open device %s', $this->_device), 0, E_ERROR, null, null, $error);
      }
    }
  }
