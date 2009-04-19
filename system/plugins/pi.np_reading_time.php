<?php

$plugin_info = array(
	'pi_name'			=> 'Reading Time',
	'pi_version'		=> '1.0',
	'pi_author'			=> 'Nathan Pitman',
	'pi_author_url'		=> 'http://www.nathanpitman.com/',
	'pi_description'	=> 'Estimates the time it will take an normal reader to read any given body of text',
	'pi_usage'			=> np_reading_time::usage()
);

class np_reading_time {

	var $string = "";
	var $before = "";
	var $seperator = "'";
	var $after = "";

    function np_reading_time()
    {
    	
    	global $TMPL;
    	
		$string = $TMPL->tagdata;
		$before = $TMPL->fetch_param('before');
		$separator = $TMPL->fetch_param('separator');
		$after = $TMPL->fetch_param('after');
		
		if ($string!="") {
		
	    	$textoclean = strip_tags($string);
		    $count = str_word_count($textoclean);
		    $average = $count / 250 * 60;
		    $min = (int)($average/60); 
		    $seg = fmod($average, 60);
		    if ($seg<10){$seg = '0' . $seg;}else{$seg=$seg;}
			$average = $min.".".$seg;
			$average = strval($average);
			$array = explode(".",$average);
			$array[1] = substr($array[1],0,2);
			$result = ($before ." ". $array[0] . $separator . $array[1] ." ". $after);
	        
	        $this->return_data = $result;
	        
        } else {
        	$this->return_data = "Error: You must provide content between the opening and closing tags which you wish to return a reading time for!";
			return;
		}
		
	}
    


// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
This plug-in is designed to calculate the average reading time for a body of text. You simply place the opening and closing tags around a body of text and the plug-in will return an average reading time.

BASIC USAGE:

{exp:np_reading_time before="Time to read this article:" seperator=":" after="minute(s)."}{body}{/exp:np_reading_time}

PARAMETERS:

before = 'Time to read this article:' (no default)
 - The text you wish to appear before the time.
	
seperator = ':' (no default)
 - The seperator which you wish to use when displayed the number of minutes required to read a body of text.
 
 after = 'minute(s)' (no default)
 - The text you wish to appear after the time.
	
RELEASE NOTES:

1.0 - Initial Release.

For updates and support check the developers website: http://nathanpitman.com/


<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}


}
?>