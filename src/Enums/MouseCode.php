<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID\Enums;

enum MouseCode: int
{
	case MOUSE_LEFT = 0x01;
	case MOUSE_RIGHT = 0x02;
	case MOUSE_MIDDLE = 0x04;
}