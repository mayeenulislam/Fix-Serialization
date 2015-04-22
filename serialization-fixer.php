<?php
/**
 * THIS IS A FORKED RAW PHP VERSION OF THE Fix-Serialization 1.2
 * @author Pau Iglesias (http://blogestudio.com)
 *
 * Version 1.2
 * It has all the PHP attributes what Pau's version had.
 * For more info read his repo
 * 
 * @link https://github.com/Blogestudio/Fix-Serialization
 *
 * Thanks to all his effort. :)
 * @author Mayeenul Islam
 */

/**
 * STEP 0:
 * Define your SQL filename here first, then run the page.
 * @var string
 */
$sql_filename = 'filename.sql';



// Unescape to avoid dump-text issues
function unescape_mysql($value) {
	return str_replace(array("\\\\", "\\0", "\\n", "\\r", "\Z",  "\'", '\"'),
					   array("\\",   "\0",  "\n",  "\r",  "\x1a", "'", '"'), 
					   $value);
}



// Fix strange behaviour if you have escaped quotes in your replacement
function unescape_quotes($value) {
	return str_replace('\"', '"', $value);
}	


$msg = '';
// Compose path from argument
$path = dirname(__FILE__).'/'.$sql_filename;
if (!file_exists($path)) {

	// Error
	echo 'Error: input file does not exists'."\n";
	echo $path."\n\n";

// File exists
} else {

	// Get file contents
	if (!($fp = fopen($path, 'r'))) {
		
		// Error
		echo 'Error: can`t open input file for read'."\n";
		echo $path."\n\n";
	
	// File opened for read
	} else {
		
		// Initializations
		$do_preg_replace = false;
	
		// Copy data
		if (!($data = fread($fp, filesize($path)))) {

			// Error
			echo 'Error: can`t read entire data from input file'."\n";
			echo $path."\n\n";
		
		// Check data
		} elseif (!(isset($data) && strlen($data) > 0)) {

			// Warning
			echo "Warning: the file is empty or can't read contents\n";
			echo $path."\n\n";
		
		// Data ok
		} else {

			// Tag context
			$do_preg_replace = true;

			// Replace serialized string values
			$data = preg_replace('!s:(\d+):([\\\\]?"[\\\\]?"|[\\\\]?"((.*?)[^\\\\])[\\\\]?");!e', "'s:'.strlen(unescape_mysql('$3')).':\"'.unescape_quotes('$3').'\";'", $data);
		}

		// Close file
		fclose($fp);
		
		// Check data
		if (!(isset($data) && strlen($data) > 0)) {
			
			// Check origin
			if ($do_preg_replace) {

				// Error
				echo "Error: preg_replace returns nothing\n";
				if (function_exists('preg_last_error')) echo "preg_last_error() = ".preg_last_error()."\n";
				echo $path."\n\n";
			}
		
		// Data Ok
		} else {

			// And finally write data
			if (!($fp = fopen($path, 'w'))) {

				// Error
				echo "Error: can't open input file for writing\n";
				echo $path."\n\n";
				
			// Open for write
			} else {
				
				// Write file data
				if (!fwrite($fp, $data)) {
					
					// Error
					echo "Error: can't write input file\n";
					echo $path."\n\n";
				}
				
				// Close file
				fclose($fp);

				$msg = 1;
			}
		}
	}
}

if( $msg !== '' ) {
	echo '<p style="color: green">Yap! Done! Let\'s check it out.</p>';
}
