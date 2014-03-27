<!-- Author : Maxim Vitoshki-Tarasov

Purpose : See MAiN section of the script for details. -->

<html>
<title>Compare Two Columns</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
</head>
<body>

<?php

class CompareTwoColumns {

	private $file, $results;
	
	public function __construct($file = null) {
	
		$this->file = empty($file) ? null : $file;
	
	return $this; }
	
	public function displayInterface() { if (empty($this->file))
	
		$image = str_replace("php", "png", $_SERVER['PHP_SELF']);
	
		print <<<EOT
					 <br />
					 <center><h2>Compare Two Columns</h2>
					 <img src="{$image}"><br /><br />
					 <form enctype="multipart/form-data" action="{$_SERVER['PHP_SELF']}" method="POST">
					 <input type="hidden" name="MAX_FILE_SIZE" value="200000000" />
					 <input name="userfile" type="file"/>
					 <input type="submit" value="Submit" />
					 </form>
					 </center>
EOT;

	return $this; }
	
	public function onSubmit() { if (empty($this->file)) {
		
		if (!empty($_FILES['userfile']['name']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
		
			$this->file = $_FILES['userfile']['tmp_name'];
		
		} }
		
	return $this; }
	
	public function compare() {
	
		if ($this->file) { $file = fopen($this->file, "r"); 
		
			$categories = fgetcsv($file);
			
			while ($columns = fgetcsv($file)) { $first[] = $columns[0]; $second[] = $columns[1]; }
			
			$this->results["In $categories[0] but not in $categories[1]"] = array_diff($first, $second);
			
			$this->results["In $categories[1] but not in $categories[0]"] = array_diff($second, $first);
		
		}
	
	return $this; }

	public function displayResults() { if (!empty($this->results)) {
	
		foreach ($this->results as $title => $result) { print "<h3>" . $title . "</h3><ul>"; 
		
			foreach ($result as $item) if (!empty($item)) print "<li>" . $item . "</li>"; print "</ul>"; } }
	
	return $this; }
	
} #CompareTwoColumns


# MAiN

$_ = new CompareTwoColumns();

$_->displayInterface()->onSubmit()->compare()->displayResults();


?>

</body>
</html>