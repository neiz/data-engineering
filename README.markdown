Living Social Associate Developer Challenge Entry

This application was written primarily in PHP and takes an input of a tab delimited file, and processes the headers followed by the data.  An attempt is then made to insert this into a MySQL database.  After success or failure, the revenue is calculated and the array is passed into the url for display on the index.  Written by Neil Allen(neil.denis.allen@gmail.com)

lsChallenge_dump.sql is a self-contained export of a skeleton of a schema for easy setup.  The database connection string is located on line #44 in dbFunctions.php


/css/ contains the relevant css files.
/js/ includes the relevant javascript files.
/temp/ is a temporary location for storage/processing of the input file.