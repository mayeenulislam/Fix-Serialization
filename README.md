## Fix Serialization

A PHP script to fix length attributes for serialized strings over database dumps (e.g. Wordpress databases)

This script can be useful if you perform text replacements in database dumps containing serialized data structures, so that reconstructs the serialized length attribute and prevents the serialized offset error in code execution.

> **DISCLAIMER**<br>
This is a FORKED version to let the user fix their file in a Raw PHP way.
To use the main file Please visit Pau Iglesias's master branch [here](https://github.com/Blogestudio/Fix-Serialization). The main repo has shell script what this repo isn't offering.

### How to use:

 - Clone the repo into your server (local or remote)
 - Export your database file into `.sql` file (i.e. `something.sql`)
 - Put your `.sql` file inside the cloned folder
 - Open the `serialization-fixer.php` and type your filename in **line#21**, like:
       ``````
       $sql_filename = 'something.sql';
       ``````
 - Run the file from your server directly using the browser, for example type:
 	   ``````
       http://localhost/serialization-fixer/serialization-fixer.php
       ``````
  - That's it :)

Licensed under the GPL version 3 or later:<br>
http://www.gnu.org/licenses/gpl.txt

Thanks Pau Iglesias (the main repo owner)<br>
From Mayeenul Islam
