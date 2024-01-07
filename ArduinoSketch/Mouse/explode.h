String* explode(String str, char delimiter, int& segmentCount, int limit = 0)
{
	int segmentMaxLength = str.length();
	String* segments = new String[segmentMaxLength];
	int segmentIndex = 0;
	int segmentStart = 0;

	for (int i = 0; i < segmentMaxLength; i++)
	{
		if (str.charAt(i) == delimiter)
		{
			segments[segmentIndex++] = str.substring(segmentStart, i);
			segmentStart = i + 1;
		}
		
		if ( limit > 0 && segmentIndex == limit )
		{
			break;
		}
	}

	// Add the last segment after the last delimiter
	segments[segmentIndex++] = str.substring(segmentStart);

	segmentCount = segmentIndex;
	return segments;
}