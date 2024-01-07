<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID\Exception;

class ArduinoKeyException extends ArduinoException
{
	public function __construct ( string $key )
	{
		parent :: __construct ( sprintf ( 'The "%s" symbol is not recognized', $key ) );
	}
}