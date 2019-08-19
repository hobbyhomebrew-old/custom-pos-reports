<?php
$reportDate = date('Y-m-d',strtotime("-1 days"));
$mail_to = "SECURED";
$from_mail = "SECURED";
$from_name = "HH Reports";
$reply_to = "SECURED";
$subject = "POS Stock Report for ".$reportDate;
$file_name = "".$reportDate.".csv";
$path = "SECURED/pos-reports/";
$file = $path.$file_name;
$file_size = filesize($file);
if ($file_size == 0) {
$message = "No POS sales.";
} else {
$message = "See attached.";
}
$handle = fopen($file, "r");
$content = fread($handle, $file_size);
fclose($Handle);
$content = chunk_split(base64_encode($content));
$boundary = md5(uniqid(time()));
$header = "From: ".$from_name." <".$from_mail.">".PHP_EOL;
$header .= "Reply-To: ".$reply_to.PHP_EOL;
$header .= "Cc: reports@joestrusz.com".PHP_EOL;
$header .= "MIME-Version: 1.0".PHP_EOL;
$header .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"".PHP_EOL;
$header .= "This is a multi-part message in MIME format.".PHP_EOL;
$header .= "--".$boundary.PHP_EOL;
$header .= "Content-type:text/plain; charset=iso-8859-1".PHP_EOL;
$header .= "Content-Transfer-Encoding: 7bit".PHP_EOL.PHP_EOL;
$header .= "$message".PHP_EOL;
$header .= "--".$boundary.PHP_EOL;
if ($file_size == 0) {
} else {
        $header .= "Content-Type: application/xml; name=\"".$file_name."\"".PHP_EOL;
        $header .= "Content-Transfer-Encoding: base64".PHP_EOL;
        $header .= "Content-Disposition: attachment; filename=\"".$file_name."\"".PHP_EOL.PHP_EOL;
        $header .= $content.PHP_EOL;
        $header .= "--".$boundary."--";
}
if (mail($mail_to, $subject, "", $header)) {
        echo "Sent";
        echo "";
} else {
        echo "Error";
        echo "";
}
?>
