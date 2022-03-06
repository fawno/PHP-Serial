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
   * Windows class provides serial connection using file stream in Windows OS
   *
   * @package Fawno\PhpSerial
   * @uses Fawno\PhpSerial\Serial Provides general serial methods
   * @uses Fawno\PhpSerial\SerialException Provides custom exception
   * @used-by Fawno\PhpSerial\SerialFile
   */
  class Windows extends Serial {
    /**
     * Sets and prepare the port for conection.
     *
     * @return Windows
     * @throws SerialException
     */
    protected function setPortOptions () : Windows {
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
     * @return Windows
     * @throws SerialException
     */
    public function open (string $mode = 'r+b') : Windows {
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
