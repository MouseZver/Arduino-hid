<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID\Enums;

enum KeyboardSystemCode: int
{
	case KEY_SLEEP = 0x01;
	case KEY_POWER = 0x02;
	case KEY_WAKE = 0x03;
}