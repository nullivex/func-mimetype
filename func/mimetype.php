<?php
/**
 *  OpenLSS - Lighter Smarter Simpler
 *
 *	This file is part of OpenLSS.
 *
 *	OpenLSS is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Lesser General Public License as
 *	published by the Free Software Foundation, either version 3 of
 *	the License, or (at your option) any later version.
 *
 *	OpenLSS is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Lesser General Public License for more details.
 *
 *	You should have received a copy of the 
 *	GNU Lesser General Public License along with OpenLSS.
 *	If not, see <http://www.gnu.org/licenses/>.
*/
namespace LSS;

//---------------------------------------------------------
//Functions credit to http://stackoverflow.com/users/47529/chaos
//	From this thread 
//		http://stackoverflow.com/questions/1147931/how-do-i-determine-the-extensions-associated-with-a-mime-type-in-php
//No licensing terms were defined they are being re-released under LGPLv2
//---------------------------------------------------------

function system_extension_mime_types() {
	# Returns the system MIME type mapping of extensions to MIME types, as defined in /etc/mime.types.
	$out = array();
	$file = fopen('/etc/mime.types', 'r');
	while(($line = fgets($file)) !== false) {
		$line = trim(preg_replace('/#.*/', '', $line));
		if(!$line)
			continue;
		$parts = preg_split('/\s+/', $line);
		if(count($parts) == 1)
			continue;
		$type = array_shift($parts);
		foreach($parts as $part)
			$out[$part] = $type;
	}
	fclose($file);
	return $out;
}

function system_extension_mime_type($file) {
	# Returns the system MIME type (as defined in /etc/mime.types) for the filename specified.
	#
	# $file - the filename to examine
	static $types;
	if(!isset($types))
		$types = system_extension_mime_types();
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if(!$ext)
		$ext = $file;
	$ext = strtolower($ext);
	return isset($types[$ext]) ? $types[$ext] : null;
}

function system_mime_type_extensions() {
	# Returns the system MIME type mapping of MIME types to extensions, as defined in /etc/mime.types (considering the first
	# extension listed to be canonical).
	$out = array();
	$file = fopen('/etc/mime.types', 'r');
	while(($line = fgets($file)) !== false) {
		$line = trim(preg_replace('/#.*/', '', $line));
		if(!$line)
			continue;
		$parts = preg_split('/\s+/', $line);
		if(count($parts) == 1)
			continue;
		$type = array_shift($parts);
		if(!isset($out[$type]))
			$out[$type] = array_shift($parts);
	}
	fclose($file);
	return $out;
}

function system_mime_type_extension($type) {
	# Returns the canonical file extension for the MIME type specified, as defined in /etc/mime.types (considering the first
	# extension listed to be canonical).
	#
	# $type - the MIME type
	static $exts;
	if(!isset($exts))
		$exts = system_mime_type_extensions();
	return isset($exts[$type]) ? $exts[$type] : null;
}
