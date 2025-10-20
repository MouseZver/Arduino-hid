<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID\Enums;

enum KeyboardMediaCode: int
{
	case KEY_VOL_UP = 0xE9;
	case KEY_VOL_DOWN = 0xEA;
	case KEY_NEXT_TRACK = 0xB5;
	case KEY_PREV_TRACK = 0xB6;
	case KEY_STOP = 0xB7;
	case KEY_PLAYPAUSE = 0xCD;
	case KEY_MUTE = 0xE2;
	case KEY_BASSBOOST = 0xE5;
	case KEY_LOUDNESS = 0xE7;
	case KEY_KB_EXECUTE = 0x74;
	case KEY_KB_HELP = 0x75;
	case KEY_KB_MENU = 0x76;
	case KEY_KB_SELECT = 0x77;
	case KEY_KB_STOP = 0x78;
	case KEY_KB_AGAIN = 0x79;
	case KEY_KB_UNDO = 0x7A;
	case KEY_KB_CUT = 0x7B;
	case KEY_KB_COPY = 0x7C;
	case KEY_KB_PASTE = 0x7D;
	case KEY_KB_FIND = 0x7E;
}