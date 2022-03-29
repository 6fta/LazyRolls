<?php
// Script for making C header file from binary files for SPIFFS initialization
echo "// autogenerated file, do not modify!\n";

$time=time();
date_default_timezone_set('UTC');
echo "// generated: ".date("r")."\n\n";
echo "#include <arduino.h>\n\n";

echo "uint32_t spiffs_time=".$time.";\n\n";
echo '#define CLASS_URL "/styles_'.dechex($time).".css\"\n";
echo '#define JS_URL "/scripts_'.dechex($time).".js\"\n\n";


$BYTES_ON_LINE = 12;

function make_c_array($filename, $var)
{
	global $BYTES_ON_LINE;
	
	$handle = fopen($filename, "rb") or die("file: '$filename' open failed.\n");

	echo "const uint8_t $var [] PROGMEM = {\n";

	$c=fgetc($handle);
	$i=0;
	while ($c !== false)
	{
		printf("0x%02X", ord($c));
		$c=fgetc($handle);
		if ($c !== false) echo ", ";
		if (++$i == $BYTES_ON_LINE) { echo "\n"; $i=0; }
	}	
	echo "};\n\n";

	fclose($handle);
}

$fav_filename = "favicon.ico";
$css_filename = "styles.css";
$js_filename = "scripts.js";

if (file_exists($fav_filename.'.gz')) { $fav_filename = $fav_filename.'.gz'; echo "#define FAV_COMPRESSED\n"; }
if (file_exists($css_filename.'.gz')) { $css_filename = $css_filename.'.gz'; echo "#define CSS_COMPRESSED\n"; }
if (file_exists( $js_filename.'.gz')) {  $js_filename =  $js_filename.'.gz'; echo "#define  JS_COMPRESSED\n"; }
make_c_array($fav_filename, "fav_icon_data");
make_c_array($css_filename, "css_data");
make_c_array( $js_filename, "js_data");


?>