<?php 
// Initialize status: if failure occurs at any point, failure will be returned
$status = "Submitted";
//

// Define temporary storage for file manipulation
$target = "temp/"; 
$target = $target . basename( $_FILES['file']['name']) ; 
//

// Check for successful upload
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) 
	{} 
	else {
		echo "Error uploading file.";
	}
//

// Read input file
$FileName = $target;
$FileHandle = fopen($FileName,"r");
$FileContent = fread ($FileHandle,filesize ($FileName));
fclose($FileHandle);
//

// Split file by line breaks
$breakUp = explode("\n", $FileContent);
//

// Split file by tab delimitations
$SplitContent = explode("\t", $FileContent);
//

// Split each line by tab delimitations to fill 2nd dimension of array
$count = 0;
foreach($breakUp as $CurrValue)
{
        $SplitContent[$count] = explode("\t", $CurrValue);
		$count++;
}
//

// Attempt MySQL db connection
$link = mysql_connect('localhost', 'root', 'toor');
if (!$link) {
	// Unsuccessful connection
    $status = "Failed";
	//
}
//

// Initialize array of revenue incase duplicate MERCHANT_NAME exists; no duplicates
for ($i = 1; $i < count($SplitContent[$i]); $i++) {
	$revenue[$SplitContent[$i][5]] = 0;
}
//

// Select database for insert statement
mysql_select_db("lschallenge", $link);
//

// Get current row from database
$result = mysql_query("SELECT * FROM data", $link);
$num_rows = mysql_num_rows($result);
//

// Loop through array of data and insert into corresponding database columns, one row per loop iteration
for ($i = 1; $i < count($SplitContent[$i]); $i++) {
	// Statement to combine revenue for current row with a matching MERCHANT_NAME row (if exists, otherwise init value of 0 will be added)
	$revenue[$SplitContent[$i][5]] = $revenue[$SplitContent[$i][5]] + $SplitContent[$i][2] * $SplitContent[$i][3];
	//
	if(!mysql_query("INSERT INTO data (ID, PURCHASER_NAME, ITEM_DESCRIPTION, ITEM_PRICE, PURCHASE_COUNT, MERCHANT_ADDRESS, MERCHANT_NAME) 
								values 
							('$num_rows', '".mysql_real_escape_string($SplitContent[$i][0])."', '".mysql_real_escape_string($SplitContent[$i][1])."', '".mysql_real_escape_string($SplitContent[$i][2])."', '".mysql_real_escape_string($SplitContent[$i][3])."', '".mysql_real_escape_string($SplitContent[$i][4])."', '".mysql_real_escape_string($SplitContent[$i][5])."')", $link))
	{
		// Unsuccessful insert
		$status = "Failed";
		//
	}
	// Successful run

	// Increment row number to keep inserting into corresponding rows
	$num_rows++;
	//
	}
//

// Serialize array of revenue for passing through the URL
	$serialized = rawurlencode(serialize($revenue));
//

// Redirect to index.php with a status code and the serialized array of revenue
	header('Location: index.php?status='.$status.'&array='.$serialized);
//
?>