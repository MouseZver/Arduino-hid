#define EB_NO_FOR
#define EB_NO_COUNTER
#define EB_NO_BUFFER
#define EB_DEB_TIME 50     // таймаут гашения дребезга кнопки (кнопка)
#define EB_CLICK_TIME 100  // таймаут ожидания кликов (кнопка)
#define EB_HOLD_TIME 400   // таймаут удержания (кнопка)



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

#include <EasyHID.h>
#include "led.h"
#include "AnalogKey.h"
#include <EncButton.h>


Button b( A0, INPUT, HIGH );
AnalogKey< A0, 1 > a;
LED led13( LED_BUILTIN, 100 );
LED led1023( PIN_D3, 500 );

bool INDICATOR_LED_1023 = false;
char INDICATOR_LED_MODE = 0x1;

bool ACTIVATED_HID = false;
bool MOUSE_CLICK_REPEAT = false;

void initHID()
{
	if ( ! ACTIVATED_HID )
	{
		HID.begin();
		
		ACTIVATED_HID = true;
		
		Serial.println( "HID USB initialized" );
	}
}

#include "closure.h"

void setup()
{
	Serial.begin( 9600 );
	Serial.println( "Hello! 🙂" );
	
	pinMode( PIN_D3, OUTPUT );
	pinMode( PIN_D5, OUTPUT );
	
	b.attach( cb );
	
	a.attach( 0, 1023 );
	//a.setWindow( 10 );
}

// Добавляем переменные для управления интервалом кликов
unsigned long lastClickTime = 0; // Время последнего клика
const unsigned long CLICK_INTERVAL = 100; // Интервал между кликами (в миллисекундах)

void loop()
{
	static const char PREAMBLE = 0xDC;
	static const uint8_t BUFFER_SIZE = 8;
	
	enum
	{
		BEGIN_HID_COMMAND = 0x7E,
		END_HID_COMMAND = 0x7F,
		MOUSE_COMMAND = 0x1,
		KEYBOARD_COMMAND = 0x2
	};
	
	//Serial.println( analogRead(A0) );
	
	if ( Serial.available() > 0 )
	{
		/*
			1 - 0xDC - Определение команда
			2
				- 0x1 - Мышь
				- 0x2 - Клавиатура
				- 0x7E - Активация HID USB
				- 0x7F - Отключение HID USB
			3 - 0x* - Определение действия
			4 - 0x* - Действие (k0)
			5 - 0x* - Действие (k1)
			6 - 0x* - Действие (k2)
			7 - 0x* - Действие (k3)
			8 - 0x* - Действие (k4)
		*/
		char buffer[BUFFER_SIZE] = {0};
		uint8_t readBytes = Serial.readBytesUntil( 0x4D, buffer, BUFFER_SIZE );
		
		if ( buffer[0] != PREAMBLE )
		{
			for ( uint8_t e = 0; e < readBytes; e++ )
			{
				Serial.println( buffer[e] );
			}
			
			b.tick();
			a.pressed();
			ledTick();
			HID.tick();
			
			return;
		}
		
		switch ( buffer[1] )
		{
			case BEGIN_HID_COMMAND:
				{
					initHID();
				}
				break;
			case END_HID_COMMAND:
				if ( digitalRead( PIN_D3 ) )
				{
					HID.end();
					digitalWrite( PIN_D3, LOW );
					Serial.println( "HID USB stopped" );
				}
				
				break;
			case MOUSE_COMMAND:
				MouseEvent( buffer );
				
				break;
			case KEYBOARD_COMMAND:
				KeyboardEvent( buffer );
				
				break;
			default:
				Serial.println( "Unknown command:" );
				Serial.println( buffer[1] );
				
				break;
		}
	}
	
	if ( MOUSE_CLICK_REPEAT )
    {
        unsigned long currentTime = millis(); // Текущее время

        // Проверяем, прошло ли достаточно времени с момента последнего клика
        if ( currentTime - lastClickTime >= CLICK_INTERVAL )
        {
            Mouse.click( MOUSE_LEFT ); // Выполняем клик
			
            lastClickTime = currentTime; // Обновляем время последнего клика
        }
    }
	
	b.tick();
	a.pressed();
	ledTick();
	HID.tick();
}

void ledTick()
{
	static bool _flashBlink = true;
	
	led13.on( ACTIVATED_HID && digitalRead( PIN_D2 ) );
	
	led13.off();
	
	//INDICATOR_LED_1023 = false;
	
	if ( INDICATOR_LED_1023 )
	{
		led1023.setPeriod( 500 );
		
		switch ( INDICATOR_LED_MODE )
		{
			default:
			case 0x1:
			{
				led1023.doubleBlink( 80, 8 );
				break;
			}
			case 0x2:
			{
				led1023.blink();
				break;
			}
			case 0x3:
			{
				if ( _flashBlink )
				{
					_flashBlink = !led1023.flash( 7 );
				}
				else
				{
					_flashBlink = led1023.doubleBlink( 50, 2 );
				}
				break;
			}
			case 0x4:
			{
				led1023.flash( 20 );
				break;
			}
			case 0x5:
			{
				led1023.setPeriod( 1500 );
				
				led1023.doubleBlink( 100, 1 );
				break;
			}
			case 0x9:
			{
				led1023.setPeriod( 5000 );
				
				led1023.blink();
				break;
			}
		}
	}
	else if ( digitalRead( PIN_D3 ) )
	{
		led1023.off();
	}
}

void MouseEvent( char* buffer )
{
	enum
	{
		MOUSE_MOVE = 0x1,
		MOUSE_CLICK = 0x2,
		MOUSE_PRESS = 0x3,
		MOUSE_RELEASE_ALL = 0x4,
		MOUSE_TEST_BEGIN = 0x7E,
		MOUSE_TEST_END = 0x7F
	};
	
	switch ( buffer[2] )
	{
		case MOUSE_MOVE:
			{
				Mouse.move( ( int ) buffer[3], ( int ) buffer[4] );
			}
			break;
		case MOUSE_CLICK:
			{
				Mouse.click( ( int ) buffer[3] );
			}
			break;
		case MOUSE_PRESS:
			{
				Mouse.press( ( int ) buffer[3] );
			}
			break;
		case MOUSE_RELEASE_ALL:
			{
				Mouse.releaseAll();
			}
			break;
		case MOUSE_TEST_BEGIN:
			{
				digitalWrite( LED_BUILTIN, HIGH );
			}
			break;
		case MOUSE_TEST_END:
			{
				digitalWrite( LED_BUILTIN, LOW );
			}
			break;
		default: 
			{
				Serial.println( "Unknown command for Mouse:" );
				Serial.println( buffer[2] );
			}
			break;
	}
}

void KeyboardEvent( char* buffer )
{
	enum
	{
		KEYBOARD_PRESS = 0x1,
		KEYBOARD_CLICK = 0x2,
		KEYBOARD_RELEASE = 0x3,
		KEYBOARD_RELEASE_ALL = 0x4,
		KEYBOARD_MEDIA_KEY = 0x5,
		KEYBOARD_SYSTEM_KEY = 0x6,
		KEYBOARD_TEST_BEGIN = 0x7E,
		KEYBOARD_TEST_END = 0x7F
	};
	
	switch ( buffer[2] )
	{
		case KEYBOARD_PRESS:
			{
				Keyboard.press( ( int ) buffer[3], ( int ) buffer[4], ( int ) buffer[5], ( int ) buffer[6], ( int ) buffer[7] );
			}
			break;
		case KEYBOARD_CLICK:
			{
				Keyboard.click( ( int ) buffer[3], ( int ) buffer[4], ( int ) buffer[5], ( int ) buffer[6], ( int ) buffer[7] );
			}
			break;
		case KEYBOARD_RELEASE:
			{
				Keyboard.release( ( int ) buffer[3], ( int ) buffer[4], ( int ) buffer[5], ( int ) buffer[6], ( int ) buffer[7] );
			}
			break;
		case KEYBOARD_RELEASE_ALL:
			{
				Keyboard.releaseAll();
			}
			break;
		case KEYBOARD_MEDIA_KEY:
			{
				Keyboard.clickMultimediaKey( ( int ) buffer[3] );
			}
			break;
		case KEYBOARD_SYSTEM_KEY:
			{
				Keyboard.clickSystemKey( ( int ) buffer[3] );
			}
			break;
		case KEYBOARD_TEST_BEGIN:
			{
				digitalWrite( PIN_D5, HIGH );
			}
			break;
		case KEYBOARD_TEST_END:
			{
				digitalWrite( PIN_D5, LOW );
			}
			break;
		default: 
			{
				Serial.println( "Unknown command for Keyboard:" );
				Serial.println( buffer[2] );
			}
			break;
	}
}