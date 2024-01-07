class LED
{
	public:
		LED( byte pin, uint16_t prd )
		{
			_pin = pin;
			_prd = prd;
			pinMode( _pin, OUTPUT );
		}
		
		void blink( bool a = true )
		{
			if ( a && isExpired() )
			{
				_flag = !_flag;
				digitalWrite( _pin, _flag );
				_tmr = millis();
			}
		}
		
		bool isExpired()
		{
			return millis() - _tmr >= _prd;
		}
		
		void on( bool a = true, bool b = true )
		{
			if ( a )
			{
				_flag = !b;
				_tmr = 0;
			}
			
			blink( a );
		}
		
		void off( bool a = true, bool b = false )
		{
			if ( _flag )
			{
				_flag = !b;
			}
			else
			{
				a = false;
			}
			
			blink( a );
		}
		
	private:
		byte _pin;
		uint32_t _tmr;
		uint16_t _prd;
		bool _flag;
};