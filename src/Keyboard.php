<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Enums\{ KeyboardCode, KeyboardMediaCode, KeyboardSystemCode };

class Keyboard extends Arduino implements SystemCodeInterface
{
	public function click( KeyboardCode ...$enums ): void
	{
		$this -> send( input: $enums, device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_CLICK );
	}
	
	public function press( KeyboardCode ...$enums ): void
	{
		$this -> send( input: $enums, device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_PRESS );
	}
	
	public function release( KeyboardCode ...$enums ): void
	{
		$this -> send( input: $enums, device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_RELEASE );
	}
	
	public function releaseAll(): void
	{
		$this -> send( input: [], device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_RELEASE_ALL );
	}
	
	public function clickMedia( KeyboardMediaCode $enum ): void
	{
		$this -> send( input: [ $enum ], device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_MEDIA_KEY );
	}
	
	public function clickSystem( KeyboardSystemCode $enum ): void
	{
		$this -> send( input: [ $enum ], device: self :: KEYBOARD_COMMAND, command: self :: KEYBOARD_SYSTEM_KEY );
	}
}