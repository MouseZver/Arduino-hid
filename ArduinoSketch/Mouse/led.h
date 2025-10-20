class LED
{
	public:
		LED( byte pin, uint16_t prd, uint8_t mode = OUTPUT )
		{
			_pin = pin;
			_prd = prd;
			pinMode( _pin, mode );
		}
		
		void setPeriod( uint16_t prd )
		{
			if ( prd != _prd )
			{
				_prd = prd;
			}
		}
		
		bool flash( int8_t fade, bool down = true )
		{
			if ( isExpired( ( (down && _flash > 0) || ( !down && 255 > _flash ) ) ? fade : 0 ) )
			{
				if ( down && !_flash )
				{
					_flash = 255;
				}
				
				down ? _flash-- : _flash++;
				
				analogWrite( _pin, _flash );
					
				_tmr = millis();
				
				if ( ! _flash || _flash == 255 ) return true;
			}
			
			return false;
		}
		
		bool doubleBlink( uint16_t delay, uint16_t repeat = 0 )
		{
			if ( isExpired( _repeat ? delay : 0 ) )
			{
				_flag = !_flag;
				digitalWrite( _pin, _flag );
				_tmr = millis();
				
				if ( !_flag && repeat && _repeat >= repeat )
				{
					_repeat = 0;
					
					return true;
				}
				if ( _flag && repeat )
				{
					_repeat++;
				}
			}
			
			return false;
		}
		
		void blink( bool a = true )
		{
			if ( a && isExpired() )
			{
				_flag = !_flag;
				digitalWrite( _pin, _flag );
				//analogWrite( _pin, _flag ? 1 : 0 );
				_tmr = millis();
			}
		}
		
		bool isExpired( uint16_t delay = 0 )
		{
			return millis() - _tmr >= ( delay ? delay : _prd );
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
		uint16_t _repeat;
		uint8_t _flash = 0;
		bool _flag;
};