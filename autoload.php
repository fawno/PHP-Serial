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

  require __DIR__ . '/src/Config/BaudRates.php';
  require __DIR__ . '/src/Config/DataBits.php';
  require __DIR__ . '/src/Config/Parity.php';
  require __DIR__ . '/src/Config/StopBits.php';
  require __DIR__ . '/src/SerialConfig.php';

  require __DIR__ . '/src/Serial.php';
  require __DIR__ . '/src/SerialException.php';
  require __DIR__ . '/src/SerialDio.php';
  //require __DIR__ . '/src/File/Windows.php';
  //require __DIR__ . '/src/File/Linux.php';
  //require __DIR__ . '/src/File/Darwin.php';
  require __DIR__ . '/src/SerialFile.php';
