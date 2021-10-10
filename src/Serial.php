<?php
	namespace Fawno\PhpSerial;

	use \ErrorException;

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

		public function __construct (string $device = null) {
			$this->setDevice($device);

			register_shutdown_function([$this, 'close']);
		}

		public function setDevice (string $device = null) {
			$this->_device = $device;
		}

		public function setDataRate (int $data_rate = 9600) {
			if (!in_array($data_rate, self::SERIAL_DATA_RATES)) {
				throw new ErrorException(sprintf('invalid data_rate value (%d)', $data_rate), 0, E_USER_WARNING);
			}

			$this->_options['data_rate'] = $data_rate;
		}

		public function setParity (int $parity = 0) {
			if (!in_array($parity, self::SERIAL_PARITY)) {
				throw new ErrorException(sprintf('invalid parity value (%d)', $parity), 0, E_USER_WARNING);
			}

			$this->_options['parity'] = $parity;
		}

		public function setDataBits (int $data_bits = 8) {
			if (!in_array($data_bits, self::SERIAL_DATA_BITS)) {
				throw new ErrorException(sprintf('invalid data_bits value (%d)', $data_bits), 0, E_USER_WARNING);
			}

			$this->_options['data_bits'] = $data_bits;
		}

		public function setStopBits (int $stop_bits = 1) {
			if (!in_array($stop_bits, self::SERIAL_STOP_BITS)) {
				throw new ErrorException(sprintf('invalid stop_bits value (%d)', $stop_bits), 0, E_USER_WARNING);
			}

			$this->_options['stop_bits'] = $stop_bits;
		}

		public function setFlowControl (int $flow_control = 1) {
			if (!in_array($flow_control, self::SERIAL_FLOW_CONTROL)) {
				throw new ErrorException(sprintf('invalid flow_control value (%d)', $flow_control), 0, E_USER_WARNING);
			}

			$this->_options['flow_control'] = $flow_control;
		}

		public function setBlocking (bool $enable) : bool {
			if (!is_resource($this->_serial)) {
				throw new ErrorException('Device must be opened to set blocking', 0, E_USER_WARNING);
			}

			return stream_set_blocking($this->_serial, $enable);
		}

		public function setTimeout (int $seconds = 0, int $microseconds = 0) : bool {
			if (!is_resource($this->_serial)) {
				throw new ErrorException('Device must be opened to set timeout', 0, E_USER_WARNING);
			}

			return stream_set_timeout($this->_serial, $seconds, $microseconds);
		}

		public function open (string $mode = 'r+b') {
			if (is_resource($this->_serial)) {
				throw new ErrorException('The device is already opened', 0, E_USER_WARNING);
			}

			if (empty($this->_device)) {
				throw new ErrorException('The device must be set before to be open', 0, E_USER_WARNING);
			}

			if (!preg_match('~^[raw]\+?b?$~', $mode)) {
				throw new ErrorException(sprintf('Invalid opening mode: %s. Use fopen() modes.', $mode), 0, E_USER_WARNING);
			}
		}

		public function close () {
			if (is_resource($this->_serial)) {
				if (!fclose($this->_serial)) {
					throw new ErrorException('Unable to close the device', 0, E_USER_WARNING);
				}
			}

			$this->_serial = null;
		}

		public function send (string $data) {
			if (!is_resource($this->_serial)) {
				throw new ErrorException('Device must be opened to write it', 0, E_USER_WARNING);
			}

			return fwrite($this->_serial, $data);
		}

		public function read (int $length = -1, int $offset = -1) {
			if (!is_resource($this->_serial)) {
				throw new ErrorException('Device must be opened to read it', 0, E_USER_WARNING);
			}

			return stream_get_contents($this->_serial, $length, $offset);
		}
	}