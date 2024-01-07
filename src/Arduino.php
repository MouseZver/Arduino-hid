<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

class Arduino
{
	protected int $microseconds = 0;
	
	public function __construct ( protected USBHID $hid )
	{}
	
	public function setMicroseconds( int $microseconds ): void
	{
		$this -> microseconds = $microseconds;
	}
}