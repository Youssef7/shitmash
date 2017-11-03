<?php

require_once APPPATH . '/lib/DB.php';


$db = DB::get_instance();
$db->get('images', ['id', '=', '3']);
$image = $db->first();

//print_r($image);
?>

<html>
<head>
	<title>Shitmash</title>
</head>
<body>
	<img src="<?php echo getCurrentURL() . 'assets/img/' . $image->name; ?>" />
</body>
</html>