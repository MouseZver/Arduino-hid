
// command:mouse:click:2
void mouseEvents( String action, String elements )
{
	if ( action == "releaseAll" )
	{
		Mouse.releaseAll();
	}
	else
	{
		int intVar = elements.toInt();
		
		if ( action == "click" )
		{
			Mouse.click( intVar );
		}
		else if ( action == "press" )
		{
			Mouse.press( intVar );
		}
	}
}