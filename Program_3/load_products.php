<?php

// Include dbconnection string
include('dbconnect.php');

// file_get_contents - reads a file
// json_decode - decodes json obviously, but the "true" turns the json into an associative array.
$json_array = json_decode(file_get_contents('products_big.json'),true);

// These two commands would dump the json array for viewing in a clear manner.
// Only needed for debugging
//echo "<pre>";
//print_r($json_array);

//For each entry in the json_array ... do something with it.
 foreach($json_array as $entry){

    // Remember to use  str_replace to replace '160' with a '~'
    // Remember to use substring to turn price into a float.
    // Create sql insert statement
    // Insert each into database here
	
	$item_id++;
		$item_category = $entry['category'];
		$item_description = $entry['h2'];
		$item_price = $entry['price'];	
		$item_modified_image = str_replace("160","~", $entry['imgs'][0]);		
		$item_modified_price = substr($item_price,1);		
		$Sql1 = "INSERT INTO `products` (`id`, `category`,`desc`, `price`, `img`) VALUES
		('$item_id', '$item_category', '$item_description', '$item_modified_price', '$item_modified_image')";

if(!$result = $conn->query($Sql1))
		{
			echo('['.$conn->error.']');
		}
}