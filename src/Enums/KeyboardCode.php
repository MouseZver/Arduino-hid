<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID\Enums;

enum KeyboardCode: int
{
	/**
	 * EN: Left Control
	 */
	case KEY_LEFT_CONTROL = 0xE0;

	/**
	 * EN: Left Shift
	 */
	case KEY_LEFT_SHIFT = 0xE1;

	/**
	 * EN: Left Alt
	 */
	case KEY_LEFT_ALT = 0xE2;

	/**
	 * EN: Left Windows
	 */
	case KEY_LEFT_WIN = 0xE3;

	/**
	 * EN: Right Control
	 */
	case KEY_RIGHT_CONTROL = 0xE4;

	/**
	 * EN: Right Shift
	 */
	case KEY_RIGHT_SHIFT = 0xE5;

	/**
	 * EN: Right Alt
	 */
	case KEY_RIGHT_ALT = 0xE6;

	/**
	 * EN: Right Windows
	 */
	case KEY_RIGHT_WIN = 0xE7;

	/**
	 * EN: Caps Lock
	 */
	case KEY_CAPS_LOCK = 0x39;

	/**
	 * EN: Scroll Lock
	 */
	case KEY_SCROLL_LOCK = 0x47;

	/**
	 * EN: Num Lock
	 */
	case KEY_NUM_LOCK = 0x53;

	/**
	 * EN: 1
	 */
	case KEY_1 = 0x1E;

	/**
	 * EN: 2
	 */
	case KEY_2 = 0x1F;

	/**
	 * EN: 3
	 */
	case KEY_3 = 0x20;

	/**
	 * EN: 4
	 */
	case KEY_4 = 0x21;

	/**
	 * EN: 5
	 */
	case KEY_5 = 0x22;

	/**
	 * EN: 6
	 */
	case KEY_6 = 0x23;

	/**
	 * EN: 7
	 */
	case KEY_7 = 0x24;

	/**
	 * EN: 8
	 */
	case KEY_8 = 0x25;

	/**
	 * EN: 9
	 */
	case KEY_9 = 0x26;

	/**
	 * EN: 0
	 */
	case KEY_0 = 0x27;

	/**
	 * EN: A
	 * RU: Ф
	 */
	case KEY_A = 0x04;

	/**
	 * EN: B
	 * RU: И
	 */
	case KEY_B = 0x05;

	/**
	 * EN: C
	 * RU: С
	 */
	case KEY_C = 0x06;

	/**
	 * EN: D
	 * RU: В
	 */
	case KEY_D = 0x07;

	/**
	 * EN: E
	 * RU: У
	 */
	case KEY_E = 0x08;

	/**
	 * EN: F
	 * RU: А
	 */
	case KEY_F = 0x09;

	/**
	 * EN: G
	 * RU: П
	 */
	case KEY_G = 0x0A;

	/**
	 * EN: H
	 * RU: Р
	 */
	case KEY_H = 0x0B;

	/**
	 * EN: I
	 * RU: Ш
	 */
	case KEY_I = 0x0C;

	/**
	 * EN: J
	 * RU: О
	 */
	case KEY_J = 0x0D;

	/**
	 * EN: K
	 * RU: Л
	 */
	case KEY_K = 0x0E;

	/**
	 * EN: L
	 * RU: Д
	 */
	case KEY_L = 0x0F;

	/**
	 * EN: ;
	 * RU: Ж
	 */
	case KEY_SEMICOLON = 0x33;

	/**
	 * EN: '
	 * RU: Э
	 */
	case KEY_APOSTROPHE = 0x34;

	/**
	 * EN: M
	 * RU: Ь
	 */
	case KEY_M = 0x10;

	/**
	 * EN: N
	 * RU: Т
	 */
	case KEY_N = 0x11;

	/**
	 * EN: O
	 * RU: Щ
	 */
	case KEY_O = 0x12;

	/**
	 * EN: P
	 * RU: З
	 */
	case KEY_P = 0x13;

	/**
	 * EN: Q
	 * RU: Й
	 */
	case KEY_Q = 0x14;

	/**
	 * EN: R
	 * RU: К
	 */
	case KEY_R = 0x15;

	/**
	 * EN: S
	 * RU: Ы
	 */
	case KEY_S = 0x16;

	/**
	 * EN: T
	 * RU: Е
	 */
	case KEY_T = 0x17;

	/**
	 * EN: U
	 * RU: Г
	 */
	case KEY_U = 0x18;

	/**
	 * EN: V
	 * RU: М
	 */
	case KEY_V = 0x19;

	/**
	 * EN: W
	 * RU: Ц
	 */
	case KEY_W = 0x1A;

	/**
	 * EN: X
	 * RU: Ч
	 */
	case KEY_X = 0x1B;

	/**
	 * EN: Y
	 * RU: Н
	 */
	case KEY_Y = 0x1C;

	/**
	 * EN: Z
	 * RU: Я
	 */
	case KEY_Z = 0x1D;

	/**
	 * EN: ,
	 * RU: Б
	 */
	case KEY_COMMA = 0x36;

	/**
	 * EN: .
	 * RU: Ю
	 */
	case KEY_PERIOD = 0x37;

	/**
	 * EN: -
	 */
	case KEY_MINUS = 0x2D;

	/**
	 * EN: =
	 */
	case KEY_EQUAL = 0x2E;

	/**
	 * EN: \
	 * RU: \
	 */
	case KEY_BACKSLASH = 0x31;

	/**
	 * EN: [
	 * RU: Х
	 */
	case KEY_SQBRAK_LEFT = 0x2F;

	/**
	 * EN: ]
	 * RU: Ъ
	 */
	case KEY_SQBRAK_RIGHT = 0x30;

	/**
	 * EN: /
	 * RU: .
	 */
	case KEY_SLASH = 0x38;

	/**
	 * EN: F1
	 */
	case KEY_F1 = 0x3A;

	/**
	 * EN: F2
	 */
	case KEY_F2 = 0x3B;

	/**
	 * EN: F3
	 */
	case KEY_F3 = 0x3C;

	/**
	 * EN: F4
	 */
	case KEY_F4 = 0x3D;

	/**
	 * EN: F5
	 */
	case KEY_F5 = 0x3E;

	/**
	 * EN: F6
	 */
	case KEY_F6 = 0x3F;

	/**
	 * EN: F7
	 */
	case KEY_F7 = 0x40;

	/**
	 * EN: F8
	 */
	case KEY_F8 = 0x41;

	/**
	 * EN: F9
	 */
	case KEY_F9 = 0x42;

	/**
	 * EN: F10
	 */
	case KEY_F10 = 0x43;

	/**
	 * EN: F11
	 */
	case KEY_F11 = 0x44;

	/**
	 * EN: F12
	 */
	case KEY_F12 = 0x45;

	/**
	 * EN: Enter
	 */
	case KEY_ENTER = 0x28;

	/**
	 * EN: Backspace
	 */
	case KEY_BACKSPACE = 0x2A;

	/**
	 * EN: Escape
	 */
	case KEY_ESC = 0x29;

	/**
	 * EN: Tab
	 */
	case KEY_TAB = 0x2B;

	/**
	 * EN: Space
	 */
	case KEY_SPACE = 0x2C;

	/**
	 * EN: Insert
	 */
	case KEY_INSERT = 0x49;

	/**
	 * EN: Home
	 */
	case KEY_HOME = 0x4A;

	/**
	 * EN: Page Up
	 */
	case KEY_PAGE_UP = 0x4B;

	/**
	 * EN: Delete
	 */
	case KEY_DELETE = 0x4C;

	/**
	 * EN: End
	 */
	case KEY_END = 0x4D;

	/**
	 * EN: Page Down
	 */
	case KEY_PAGE_DOWN = 0x4E;

	/**
	 * EN: Print Screen
	 */
	case KEY_PRINTSCREEN = 0x46;

	/**
	 * EN: Right Arrow
	 */
	case KEY_ARROW_RIGHT = 0x4F;

	/**
	 * EN: Left Arrow
	 */
	case KEY_ARROW_LEFT = 0x50;

	/**
	 * EN: Down Arrow
	 */
	case KEY_ARROW_DOWN = 0x51;

	/**
	 * EN: Up Arrow
	 */
	case KEY_ARROW_UP = 0x52;

	/**
	 * EN: ~
	 * RU: Ё
	 */
	case KEY_TILDE = 0x35;
}