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
   * @since         0.0.1
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */

  require __DIR__ . '/src/SerialBaudRates.php';
  require __DIR__ . '/src/SerialDataBits.php';
  require __DIR__ . '/src/SerialParity.php';
  require __DIR__ . '/src/SerialStopBits.php';
  require __DIR__ . '/src/SerialConfig.php';

  require __DIR__ . '/src/Serial.php';
  require __DIR__ . '/src/SerialException.php';
  require __DIR__ . '/src/SerialDio.php';
  //require __DIR__ . '/src/SerialFileWindows.php';
  //require __DIR__ . '/src/SerialFileLinux.php';
  //require __DIR__ . '/src/SerialFileDarwin.php';
  require __DIR__ . '/src/SerialFile.php';
