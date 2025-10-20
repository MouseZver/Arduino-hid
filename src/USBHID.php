<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Exceptions\ArduinoException;

class USBHID implements SystemCodeInterface
{
	private $serial;
	
	public function __construct ( 
		int $com, 
		int $baud = 9600, 
		string $parity = 'n', 
		int $data = 8, 
		int $stop = 1, 
		string $to = 'off', 
		string $xon = 'off', 
		string $odsr = 'off', 
		string $octs = 'off', 
		string $dtr = 'on', 
		string $rts = 'on', 
		string $idsr = 'off',
		private readonly string $suffix = "\n"
	)
	{
		shell_exec ( "mode com{$com}: baud={$baud} parity={$parity} data={$data} stop={$stop} to={$to} xon={$xon} odsr={$odsr} octs={$octs} dtr={$dtr} rts={$rts} idsr={$idsr}" );
		
		$this -> serial = fopen ( 'COM' . $com, 'w' );
		
		if ( is_bool ( $this -> serial ) )
		{
			return;
		}
		
		sleep ( 2 );
		
		register_shutdown_function ( function ()
		{
			$this -> close();
		} );
	}
	
	public function send( array $command, int $microseconds = 0 ): void
	{
		if ( ! is_resource ( $this -> serial ) )
		{
			throw new ArduinoException( 'Serial is not resource.' );
		}
		
		if ( ( count ( $command ) - 2 ) > 5 )
		{
			throw new ArduinoException( "The maximum number of arguments should not exceed 5" );
		}
		
		$bytes = array_map ( 'chr', [ self :: PREAMBLE, ...$command ] );
		
		if ( fwrite ( $this -> serial, implode ( '', $bytes ) . $this -> suffix ) === false )
		{
			throw new ArduinoException( 'Error when sending data: ' . implode ( '', $command ) );
		}
		
		//echo $command . $this -> suffix;
		
		usleep ( $microseconds );
	}
	
	public function close(): void
	{
		if ( is_resource ( $this -> serial ) )
		{
			fclose ( $this -> serial );
		}
	}
	
	public function start(): void
	{
		//$this -> send( 'ea2b2676c28c0db26d39331a336c6b92' ); // start token
		$this -> send( command: [ self :: BEGIN_HID_COMMAND ] );
	}
	
	public function stop(): void
	{
		$this -> send( command: [ self :: END_HID_COMMAND ] );
	}
	
	public function test(): void
	{
		$i = 0;
		
		while ( $i++ < 3 )
		{
			foreach ( [ 
				[ USBHID :: MOUSE_COMMAND, USBHID :: MOUSE_TEST_BEGIN ],
				[ USBHID :: KEYBOARD_COMMAND, USBHID :: KEYBOARD_TEST_BEGIN ],
				[ USBHID :: MOUSE_COMMAND, USBHID :: MOUSE_TEST_END ], 
				[ USBHID :: KEYBOARD_COMMAND, USBHID :: KEYBOARD_TEST_END ],
			] AS $make )
			{
				$this -> send( command: $make );
				
				sleep ( 1 );
			}
		}
		
		echo 'SUCCESS' . PHP_EOL;
	}
}