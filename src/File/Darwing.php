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
  declare(strict_types=1);

  namespace Fawno\PhpSerial\File;

  use Fawno\PhpSerial\Serial;
  use Fawno\PhpSerial\SerialException;

  /**
   * Darwing class provides serial connection using file stream in OSX OS
   *
   * @package Fawno\PhpSerial
   * @uses Fawno\PhpSerial\Serial Provides general serial methods
   * @uses Fawno\PhpSerial\SerialException Provides custom exception
   * @used-by Fawno\PhpSerial\SerialFile
   */
  class Darwing extends Serial {
    /**
     * Sets and prepare the port for conection.
     *
     * @return Darwing
     * @throws SerialException
     */
    protected function setPortOptions () : Darwing {
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

      return $this;
    }


    /**
     * Binds a named resource, specified by setDevice, to a stream.
     *
     * @param string $mode
     * The mode parameter specifies the type of access you require to the stream (as `fopen()`).
     *
     * @return Darwing
     * @throws SerialException
     */
    public function open (string $mode = 'r+b') : Darwing {
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

      return $this;
    }
  }
