<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Enums\MouseCode;

class Mouse extends Arduino implements SystemCodeInterface
{
	public function click( MouseCode $enum ): void
	{
		$this -> send( input: [ $enum ], device: self :: MOUSE_COMMAND, command: self :: MOUSE_CLICK );
	}
	
	public function press( MouseCode $enum ): void
	{
		$this -> send( input: [ $enum ], device: self :: MOUSE_COMMAND, command: self :: MOUSE_PRESS );
	}
	
	public function releaseAll(): void
	{
		$this -> send( input: [], device: self :: MOUSE_COMMAND, command: self :: MOUSE_RELEASE_ALL );
	}
}