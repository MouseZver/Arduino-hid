void cb()
{
	static bool status0 = false;
	
	switch ( b.action() )
	{
		case EB_CLICK: // начало клика
		{
			status0 = a.status(0);
			
			break;
		}
		case EB_CLICKS: // завершение клика
		{
			if ( status0 && b.getClicks() == 1 )
			{
				initHID();
				
				Serial.println( analogRead(A0) );
				
				INDICATOR_LED_1023 = !MOUSE_CLICK_REPEAT;
				
				MOUSE_CLICK_REPEAT = !MOUSE_CLICK_REPEAT;
			}
			
			status0 = false;
			
			break;
		}
		case EB_HOLD: // удержание клика
		{
			if ( a.status(0) && ! b.getClicks() ) // удержание без повторных кликов
			{
				initHID();
				
				Mouse.releaseAll();
				
				Keyboard.releaseAll();
			}
			
			status0 = false;
			
			break;
		}
	}
}