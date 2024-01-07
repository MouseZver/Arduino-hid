<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

class Mouse extends Arduino
{
	private const
		MOUSE_BUTTON_CLICK = 'command:mouse:click:',
		MOUSE_BUTTON_PRESS = 'command:mouse:press:',
		MOUSE_BUTTONS_RESET = 'command:mouse:releaseAll:';
	
	private function send( string $input, string $command ): void
	{
		$this -> hid -> send( command: $command . $input, microseconds: $this -> microseconds );
	}
	
	public function leftClick(): void
	{
		$this -> send( input: '1', command: self :: MOUSE_BUTTON_CLICK );
	}
	
	public function rightClick(): void
	{
		$this -> send( input: '2', command: self :: MOUSE_BUTTON_CLICK );
	}
	
	public function middleClick(): void
	{
		$this -> send( input: '4', command: self :: MOUSE_BUTTON_CLICK );
	}
	
	public function leftPress(): void
	{
		$this -> send( input: '1', command: self :: MOUSE_BUTTON_PRESS );
	}
	
	public function rightPress(): void
	{
		$this -> send( input: '2', command: self :: MOUSE_BUTTON_PRESS );
	}
	
	public function middlePress(): void
	{
		$this -> send( input: '4', command: self :: MOUSE_BUTTON_PRESS );
	}
	
	public function reset(): void
	{
		$this -> send( input: '0', command: self :: MOUSE_BUTTONS_RESET );
	}
}