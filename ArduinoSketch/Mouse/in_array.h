bool in_array( String element, String *array )
{
	int max = sizeof( array );
	
	for ( int i = 0; i < max; i++ )
	{
		if ( array[i] == element )
		{
			return true;
		}
	}
	
	return false;
}