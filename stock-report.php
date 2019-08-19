<?php
$mysql_username = 'SECURED';
$mysql_password = 'SECURED';
$mysql_hostname = 'SECURED';
$mysql_database = 'SECURED';
$reportDate = date('Y-m-d',strtotime("-1 days"));
$conn = new mysqli($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
//$sql = "SELECT * FROM pos_reports;";
$sql = "SELECT * FROM pos_reports WHERE date = '".$reportDate."';";
$result = $conn->query($sql);
$attachment = "SECURED/pos-reports/".$reportDate.".csv";
$fileContent = "";
if ($result->num_rows > 0) {
        $fileContent .= "sku, name, quantity\n";
        while($row = $result->fetch_assoc()) {
                $fileContent .= $row["sku"]. "," . $row["name"]. ",-" . $row["quantity"]."\n";
        }
}
$handle = fopen($attachment, 'w');
fwrite($handle, $fileContent);
fclose($handle);
?>
