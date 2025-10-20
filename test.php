<?php

use Nouvu\ArduinoHID\{ USBHID, Mouse, Keyboard };

require 'src/Enums/KeyboardCode.php';
require 'src/Enums/KeyboardMediaCode.php';
require 'src/Enums/KeyboardSystemCode.php';
require 'src/Enums/MouseCode.php';
require 'src/SystemCodeInterface.php';
require 'src/Exceptions/ArduinoException.php';
require 'src/USBHID.php';
require 'src/Arduino.php';
require 'src/Keyboard.php';
require 'src/Mouse.php';



$hid = new USBHID( 6 );

$hid -> test();
