<?
	/**
	 * Opens a raw direct IO stream.
	 *
	 * dio_raw (string filename, string mode[, array options]) : ?resource
	 *
	 * @param string $filename
	 * The pathname of the file to open.
	 * @param string $mode
	 * The mode parameter specifies the type of access you require to the stream (as *fopen()*).
	 * @param array|null $options
	 * The currently available options are:
	 * - 'data_rate' - baud rate of the port - can be 75, 110, 134, 150, 300, 600, 1200, 1800, 2400, 4800, 7200, 9600, 14400, 19200, 38400, 57600, 115200, 56000, 128000 or 256000 default value is 9600.
	 * - 'data_bits' - data bits - can be 8, 7, 6 or 5. Default value is 8.
	 * - 'stop_bits' - stop bits - can be 1 or 2. Default value is 1.
	 * - 'parity' - can be 0, 1 or 2. Default value is 0.
	 * - 'flow_control' - can be 0 or 1. Default value is 1.
	 * - 'is_canonical' - can be 0 or 1. Default value is 1.
	 * @return resource|null A stream resource or null on error.
	 */
	function dio_raw (string $filename, string $mode, ?array $options) : ?resource {}

	/**
	 * Opens a serial direct IO stream.
	 *
	 * dio_serial (string $filename, string $mode[, array $options = null]) : ?resource
	 *
	 * @param string $filename
	 * The pathname of the file to open.
	 *
	 * @param string $mode
	 * The mode parameter specifies the type of access you require to the stream (as *fopen()*).
	 *
	 * @param array|null $options
	 * The currently available options are:
	 * - 'data_rate' - baud rate of the port - can be 75, 110, 134, 150, 300, 600, 1200, 1800, 2400, 4800, 7200, 9600, 14400, 19200, 38400, 57600, 115200, 56000, 128000 or 256000 default value is 9600.
	 * - 'data_bits' - data bits - can be 8, 7, 6 or 5. Default value is 8.
	 * - 'stop_bits' - stop bits - can be 1 or 2. Default value is 1.
	 * - 'parity' - can be 0, 1 or 2. Default value is 0.
	 * - 'flow_control' - can be 0 or 1. Default value is 1.
	 * - 'is_canonical' - can be 0 or 1. Default value is 1.
	 * @return resource|null A stream resource or null on error.
	 */
	function dio_serial (string $filename, string $mode, ?array $options) : ?resource {}
