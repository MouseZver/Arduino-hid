<?php

declare ( strict_types = 1 );

namespace Nouvu\ArduinoHID;

use Error;

class USBHID
{
	private $serial;
	
	private string $suffix = "\n";
	
	public function __construct ( 
		int $com, int $baud = 9600, string $parity = 'n', int $data = 8, int $stop = 1, 
		string $to = 'off', string $xon = 'off', string $odsr = 'off', 
		string $octs = 'off', string $dtr = 'on', string $rts = 'on', string $idsr = 'off'
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
		
		//$this -> send( 'ea2b2676c28c0db26d39331a336c6b92' ); // start token
	}
	
	public function send( string $command, int $microseconds = 0 ): void
	{
		if ( ! is_resource ( $this -> serial ) )
		{
			throw new Error( 'Serial is not resource.' );
		}
		
		if ( fwrite ( $this -> serial, $command . $this -> suffix ) === false )
		{
			throw new ArduinoException( 'Error when sending data: ' . $command );
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
		$this -> send( 'ea2b2676c28c0db26d39331a336c6b92' ); // start token
	}
}