<?php
  namespace Fawno\PhpSerial;

  use \ErrorException;
  use Fawno\PhpSerial\Serial;

  /**
   * @package Fawno\PhpSerial
   *
  */
  class SerialFileWindows extends Serial {
    /**
     * Set and prepare the port for conection.
     *
     * @return void
     * @throws ErrorException
     */
    protected function setPortOptions () {
      $params = ['device' => $this->_device] + $this->_options;
      $param_formats = [
        'parity' => [0 => 'n', 1 => 'o', 2 => 'e'],
        'flow_control' => [0 => 'off', 1 => 'on'],
      ];

      foreach ($param_formats as $param => $values) {
        $params[$param] = $values[$params[$param]];
      }

      $command = 'mode %s baud=%s data=%s stop=%s parity=%s xon=%s';
      $command = sprintf($command, ...array_values($params));

      $message = exec($command, $output, $result_code);
      if ($result_code) {
        throw new ErrorException(utf8_encode($message), $result_code, E_USER_WARNING);
      }
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
      $this->setPortOptions();

      parent::open($mode);

      error_clear_last();
      $this->_serial = @fopen($this->_device, $mode);

      if (!is_resource($this->_serial)) {
        $error = error_get_last();
        $error = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        throw new ErrorException(sprintf('Unable to open the device %s', $this->_device), 0, E_USER_WARNING, $error);
      }
    }
  }
