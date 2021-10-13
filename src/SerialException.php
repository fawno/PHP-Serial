<?php
  namespace Fawno\PhpSerial;

  use \Throwable;
  use \Exception;

  /**
   * @package Fawno\PhpSerial
   */
  class SerialException extends Exception {
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
    public function __construct (string $message = '', int $code = 0, int $severity = E_ERROR, string $filename = null, int $line = null , Throwable $previous = null) {
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
