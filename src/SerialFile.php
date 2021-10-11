<?php
	namespace Fawno\PhpSerial;

	use \ErrorException;
	use Fawno\PhpSerial\SerialFileWindows;
	use Fawno\PhpSerial\SerialFileLinux;
	use Fawno\PhpSerial\SerialFileDarwing;

	$sysName = php_uname();
	$osName = preg_replace('~^.*(Linux|Darwing|Windows).*$~', '$1', $sysName);
	$classFile = __DIR__ . '/SerialFile' . $osName . '.php';

	if (is_file($classFile)) {
		include $classFile;
	}

	if (!class_exists('Fawno\PhpSerial\SerialFile' . $osName)) {
		throw new ErrorException(sprintf('Host OS "%s" is unsupported', $osName), 0, E_USER_WARNING);
	}

	switch ($osName) {
		case 'Windows':
			{
				/**
				 * @package Fawno\PhpSerial
				 *
				*/
				class SerialFile extends SerialFileWindows {}
			}
			break;
		case 'Linux':
			{
				/**
				 * @package Fawno\PhpSerial
				 *
				*/
				class SerialFile extends SerialFileLinux {}
			}
			break;
		case 'Darwing':
			{
				/**
				 * @package Fawno\PhpSerial
				 *
				*/
				class SerialFile extends SerialFileDarwing {}
			}
			break;
	}
