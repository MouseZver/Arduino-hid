//#include <Codekeys.h>
#include <EasyHID.h>
//#include <HIDPrivate.h>
//#include <usbconfig.h>

#define PIN_D2 2
#define PIN_D3 3
#define PIN_D4 4
#define PIN_D5 5
#define PIN_D6 6
#define PIN_D7 7
#define PIN_D8 8
#define PIN_D9 9
#define PIN_D10 10
#define PIN_D11 11
#define PIN_D12 12

#include "explode.h"
#include "led.h"
#include "in_array.h"
#include "mouseEvents.h"
#include "keyboardEvents.h"
#include "button.h"



void setup()
{
	Serial.begin( 9600 );
	Serial.println( "Hello! 🙂" );
	
	pinMode( PIN_D3, OUTPUT );
	pinMode( PIN_D12, OUTPUT );
}

LED led5( PIN_D5, 100 );

LED led13( LED_BUILTIN, 1000 );

button btn6( PIN_D6 );

String deviceName[] = { "mouse", "keyboard" };
String result;

void loop()
{
	static uint32_t tmr = millis();
	static bool leftButtonClick = false;
	
	if ( btn6.click() )
	{
		leftButtonClick = ! leftButtonClick;
		
		initUSB( true );
		
		tmr = millis();
	}
	
	if ( leftButtonClick )
	{
		Mouse.click( MOUSE_LEFT );
	}
	
	if ( digitalRead( PIN_D3 ) && digitalRead( PIN_D2 ) )
	{
		tmr = millis();
	}
	else if ( digitalRead( PIN_D3 ) && millis() - tmr >= 10000 )
	{
		Serial.println("Bad connect USB HID! Please reload your Computer.");
		
		tmr = millis() - 5000;
	}
	
	if ( Serial.available() > 0 )
	{
		result = Serial.readStringUntil( '\n' );
		
		int segmentCount;
		String *segments = explode( result, ':', segmentCount, 3 );
		
		if ( ! digitalRead( PIN_D3 ) && result == "ea2b2676c28c0db26d39331a336c6b92" )
		{
			initUSB( true );
			
			tmr = millis();
		}
		else if ( digitalRead( PIN_D3 ) && validatorSegments( segmentCount, segments ) )
		{
			if ( segments[1] == "mouse" )
			{
				mouseEvents( segments[2], segments[3] );
			}
			else
			{
				keyboardEvents( segments[2], segments[3] );
			}
		}
		else
		{
			Serial.println("Miss data:");
			Serial.println( result );
		}
		
		delete[] segments;  // Free the memory allocated for segments
		result = "";
	}
	
	ledTick();
	
	HID.tick();
}

void initUSB( bool flag )
{
	if ( ! digitalRead( PIN_D3 ) && flag )
	{
		HID.begin();
		digitalWrite( PIN_D3, HIGH );
		Serial.println("usb connect");
	}
}

void ledTick()
{
	led5.on( digitalRead( PIN_D2 ) );
	
	led5.off();
	
	led13.blink( digitalRead( PIN_D3 ) );
	
	led13.off();
}

bool validatorSegments( int segmentCount, String *segments )
{
	return segmentCount >= 4
		&& 
		segments[0] == "command" 
		&& 
		in_array( segments[1], deviceName );
}
