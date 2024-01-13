<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Exceptions\{ ArduinoException, ArduinoKeyException };

class Keyboard extends Arduino
{
	private array $keyList = [
		'LEFT_CONTROL' => 224,
		'LEFT_SHIFT' => 225,
		'LEFT_ALT' => 226,
		'LEFT_GUI' => 227,
		'LEFT_WIN' => 227,
		'RIGHT_CONTROL' => 228,
		'RIGHT_SHIFT' => 229,
		'RIGHT_ALT' => 230,
		'RIGHT_GUI' => 231,
		'RIGHT_WIN' => 231,
		'CAPS_LOCK' => 57,
		'SCROLL_LOCK' => 71,
		'NUM_LOCK' => 83,
		'1' => 30,
		'2' => 31,
		'3' => 32,
		'4' => 33,
		'5' => 34,
		'6' => 35,
		'7' => 36,
		'8' => 37,
		'9' => 38,
		'0' => 39,
		'A' => 4,
		'B' => 5,
		'C' => 6,
		'D' => 7,
		'E' => 8,
		'F' => 9,
		'G' => 10,
		'H' => 11,
		'I' => 12,
		'J' => 13,
		'K' => 14,
		'L' => 15,
		'M' => 16,
		'N' => 17,
		'O' => 18,
		'P' => 19,
		'Q' => 20,
		'R' => 21,
		'S' => 22,
		'T' => 23,
		'U' => 24,
		'V' => 25,
		'W' => 26,
		'X' => 27,
		'Y' => 28,
		'Z' => 29,
		'COMMA' => 54,
		'PERIOD' => 55,
		'MINUS' => 45,
		'EQUAL' => 46,
		'BACKSLASH' => 49,
		'SQBRAK_LEFT' => 47,
		'SQBRAK_RIGHT' => 48,
		'SLASH' => 56,
		'F1' => 58,
		'F2' => 59,
		'F3' => 60,
		'F4' => 61,
		'F5' => 62,
		'F6' => 63,
		'F7' => 64,
		'F8' => 65,
		'F9' => 66,
		'F10' => 67,
		'F11' => 68,
		'F12' => 69,
		'ENTER' => 40,
		'BACKSPACE' => 42,
		'ESC' => 41,
		'TAB' => 43,
		'SPACE' => 44,
		'INSERT' => 73,
		'HOME' => 74,
		'PAGE_UP' => 75,
		'DELETE' => 76,
		'END' => 77,
		'PAGE_DOWN' => 78,
		'PRINTSCREEN' => 70,
		'ARROW_RIGHT' => 79,
		'ARROW_LEFT' => 80,
		'ARROW_DOWN' => 81,
		'ARROW_UP' => 82,
	];
	
	private const
		KEYBOARD_CLICK = 'command:keyboard:click',
		KEYBOARD_PRESS = 'command:keyboard:press',
		KEYBOARD_RELEASE = 'command:keyboard:release',
		KEYBOARD_RELEASEALL = 'command:keyboard:releaseAll:0';
	
	private function validation( array $input ): void
	{
		if ( count ( $input ) > 5 )
		{
			throw new ArduinoException( "The maximum number of arguments should not exceed 5" );
		}
		
		foreach ( $input AS $key )
		{
			if ( ! isset ( $this -> keyList[$key] ) )
			{
				throw new ArduinoKeyException( key: $key );
			}
		}
	}
	
	private function send( array $input, string $command ): void
	{
		$keys = array_map ( 'strtoupper', $input );
		
		$this -> validation( input: $keys );
		
		$keys = array_map ( fn( string $k ) => $this -> keyList[$k], $keys );
		
		$this -> hid -> send( command: implode ( ':', [ $command, ...$keys ] ), microseconds: $this -> microseconds );
	}
	
	public function click( string | int ...$k ): void
	{
		$this -> send( input: $k, command: self :: KEYBOARD_CLICK );
	}
	
	public function press( string | int ...$k ): void
	{
		$this -> send( input: $k, command: self :: KEYBOARD_PRESS );
	}
	
	public function release( string | int ...$k ): void
	{
		$this -> send( input: $k, command: self :: KEYBOARD_RELEASE );
	}
	
	public function releaseAll(): void
	{
		$this -> send( input: [], command: self :: KEYBOARD_RELEASEALL );
	}
}