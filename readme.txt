The PHP Mail Script
Modified December 13, 2005
email me at <clunky at gmail dot com>

This release of Mail Script is the first to have MySQL support. 

It can be installed like this:

1. Make sure you have at least PHP 4.1 installed (I use it with PHP 5.0.4).
2. Make sure you have MySQL installed
3. Set up a MySQL database
4. Set up a MySQL account, and grant it access to the database
5. Upload all the files
6. Run nstall.php
   When you are done with these, PHP will try to delete these three files and change permissions of conf.php to 777.  
   If the files are not deleted, or CHMOD dosent work, you shoud do these manually.
7. Point your browser to index.php and try sending an email.
8. Go to admin.php and check it it has been logged. If it has all the fields, pat yourself on the back

	-bobmilkman
	 http://www.dubemail.com