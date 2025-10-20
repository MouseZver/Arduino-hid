<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Exceptions\ArduinoException;
use Nouvu\ArduinoHID\Enums\{ KeyboardCode, KeyboardMediaCode, KeyboardSystemCode, MouseCode };

class Arduino
{
	protected int $microseconds = 0;
	
	public function __construct ( protected USBHID $hid )
	{}
	
	public function setMicroseconds( int $microseconds ): void
	{
		$this -> microseconds = $microseconds;
	}
	
	protected function send( array $input, int $device, int $command ): void
	{
		$keys = array_map ( fn( KeyboardCode | KeyboardMediaCode | KeyboardSystemCode | MouseCode $e ) => $e -> value, $input );
		
		$this -> hid -> send( 
			command: [ $device, $command, ...$keys ], 
			microseconds: $this -> microseconds 
		);
	}
}