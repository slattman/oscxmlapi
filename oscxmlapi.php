<?
/*
	osCXMLApi v1.5 r3 ©2007
	Coding by Brad Slattman - postmaster@phaseonemedia.com
	Testing by Brian Mix - brian@brokerbin.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	See the GNU General Public License for more details.

	http://www.gnu.org/licenses/gpl.html

*/

/* Define some Constants */
define('OSCXMLAPI_USERNAME', 'username'); // required to access the api
define('OSCXMLAPI_PASSWORD', 'password'); // required to access the api
define('OSCXMLAPI_DEBUG', TRUE); // this turns the actual mysql queries on and off.

/* Integrate with OSC */
require_once('includes/application_top.php');

/* Include the OSCXMLAPI Class */
require_once('includes/classes/oscxmlapi.class.php');

/* Check for a request and execute it */
if ($_REQUEST['xmlDoc']) {
	$oscxmlapi = new oscxmlapi;
	?><pre><? print_r($oscxmlapi->process($_REQUEST['xmlDoc']));
}
?>