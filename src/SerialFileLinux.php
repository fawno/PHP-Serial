<?php
  namespace Fawno\PhpSerial;

  use \ErrorException;
  use Fawno\PhpSerial\Serial;

  /**
   * @package Fawno\PhpSerial
   *
  */
  class SerialFileLinux extends Serial {
    /**
     * Set and prepare the port for conection.
     *
     * @return void
     * @throws ErrorException
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

      $command = 'stty -F %s %s cs%s %s %s %s';
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
