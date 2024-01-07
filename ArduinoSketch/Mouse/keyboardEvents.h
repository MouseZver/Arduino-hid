


// command:keyboard:click:H:E:L:L:O
// command:keyboard:click:11:8:15:15:18
void keyboardEvents( String action, String elements )
{
	if ( action == "releaseAll" )
	{
		Keyboard.releaseAll();
	}
	else
	{
		int segmentCount;
		String *segments = explode( elements, ':', segmentCount, 4 );
		
		for ( int e = 0; e < segmentCount; e++ )
		{
			int intVar = segments[e].toInt();
			
			if ( action == "click" )
			{
				Keyboard.click( intVar );
			}
			else if ( action == "press" )
			{
				Keyboard.press( intVar );
			}
			else if ( action == "release" )
			{
				Keyboard.release( intVar );
			}
		}
		
		delete[] segments;  // Free the memory allocated for segments
	}
}