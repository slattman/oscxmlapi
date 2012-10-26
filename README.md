oscxmlapi
=========

an xml api for manipulating data in various open source based php shopping cart systems


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

1) Introduction
2) How to install
3) How to use
4) Credits

INTRODUCTION
OSCXMLAPI is an attempt to create an xml api for oscommerce. It 
allows developers to make mysql queries via a post request to the 
api using an xml format.


HOW TO INSTALL
Simply upload it to your catalog and load the test.php page into 
your browser. The username, password, and debug mode can
all be changed in the oscxmlapi.php file.


HOW TO USE
I could go on and on about how to use this thing, but I can't right now.
Check out the test.php page. There are severable methods available to update insert and/or delete all sorts of information for products, categories, customers, and orders.
It is easy to extend to support even more functionality and request. Play around with it and see what you can do ;)

Current Acceptable Actions and Types
-ACTIONS:
	INSERT
	UPDATE
	DELETE

-TYPES:
	PRODUCTS
	CATEGORIES
	ORDERS


Mysql Field names are required to run queries using the api. See the test.php page for a more in depth example of usage.





CREDITS

Core Coding & Development - Brad Slattman
Testing & Bug Fixes - Brian Mix


