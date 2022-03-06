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
   * @since         1.0.0
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */
  declare(strict_types=1);

  namespace Fawno\PhpSerial;

  use \Throwable;
  use \Exception;

  /**
   * Provides custom exception class.
   *
   * @package Fawno\PhpSerial
   * @used-by Fawno\PhpSerial\Serial
   * @used-by Fawno\PhpSerial\SerialDio
   * @used-by Fawno\PhpSerial\SerialFile
   * @used-by Fawno\PhpSerial\SerialFileDawing
   * @used-by Fawno\PhpSerial\SerialFileLinux
   * @used-by Fawno\PhpSerial\SerialFileWindows
   */
  class SerialException extends Exception {
    public const ERROR_INDETERMINATE = 0;
    public const ERROR_DATA_RATE     = 1;
    public const ERROR_DATA_BITS     = 2;
    public const ERROR_STOP_BITS     = 3;
    public const ERROR_PARITY        = 4;

    protected int $severity;

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @param string $message
     * [optional] The Exception message to throw.
     *
     * @param int $code
     * [optional] The Exception code.
     *
     * @param int $severity
     * [optional] The Exception severity.
     * Note:
     * While the severity can be any int value, it is intended that the error constants be used.
     *
     * @param string|null $filename
     * [optional] The filename where the exception is thrown.
     *
     * @param int|null $line
     * [optional] The line number where the exception is thrown.
     *
     * @param Throwable|null $previous
     * [optional] The previous throwable used for the exception chaining.
     *
     * @return void
     */
    public function __construct (string $message = '', int $code = self::ERROR_INDETERMINATE, int $severity = E_ERROR, string $filename = null, int $line = null , Throwable $previous = null) {
      $this->severity = $severity;

      if (!is_null($filename)) {
        $this->filename = $filename;
      }

      if (!is_null($line)) {
        $this->line = $line;
      }

      parent::__construct($message, $code, $previous);
    }

    /**
     * Gets the exception severity
     *
     * @return int
     * Returns the severity of the exception.
     */
    public function getSeverity () : int {
      return $this->severity;
    }
  }
