<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

interface SystemCodeInterface
{
	public const BEGIN_HID_COMMAND = 0x7E;
	public const END_HID_COMMAND = 0x7F;
	public const MOUSE_COMMAND = 0x1;
	public const MOUSE_TEST_BEGIN = 0x7E;
	public const MOUSE_TEST_END = 0x7F;
	public const MOUSE_MOVE = 0x1;
	public const MOUSE_CLICK = 0x2;
	public const MOUSE_PRESS = 0x3;
	public const MOUSE_RELEASE_ALL = 0x4;
	public const KEYBOARD_COMMAND = 0x2;
	public const KEYBOARD_TEST_BEGIN = 0x7E;
	public const KEYBOARD_TEST_END = 0x7F;
	public const KEYBOARD_PRESS = 0x1;
	public const KEYBOARD_CLICK = 0x2;
	public const KEYBOARD_RELEASE = 0x3;
	public const KEYBOARD_RELEASE_ALL = 0x4;
	public const KEYBOARD_MEDIA_KEY = 0x5;
	public const KEYBOARD_SYSTEM_KEY = 0x6;
	public const PREAMBLE = 0xDC;
}