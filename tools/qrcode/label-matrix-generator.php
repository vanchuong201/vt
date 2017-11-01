<?php

//http://localhost/test/php-excel-reader-2.21/label-matrix-generator.php?numberOfColumns=7&numberOfRows=27&labelSize=25.4x10&labelGapX=2.5&text=I%27m+a+label&outline=true&labelRadius=2
//php ./label-matrix-generator.php numberOfColumns=8 numberOfRows=6 labelGapX=2.5 outline=true labelRadius=2 labelSize=68.031x124.724 | tee ex.svg

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('set max_allowed_packet', 1024);
ini_set('memory_limit', '-1');
set_time_limit(0); // cấp phát thêm bộ nhớ cho hàm
// Construct $params from $argv or $_GET.

if (php_sapi_name() == 'cli') {
    $paramElements = array_slice($argv, 1);
    $params = array();
    foreach ($paramElements as $paramElement)
    {
        @list($paramName, $paramValue) = explode('=', $paramElement, 2);
        if (!is_null($paramName) && !is_null($paramValue)) {
            $params[$paramName] = $paramValue;
        }
    }
} else {
    $params = $_GET;
}

// Define the list of available parameters.

$availableParams = array(
    'numberOfColumns' => array('mandatory'=>true,  'type'=>'int'),
    'numberOfRows'    => array('mandatory'=>true,  'type'=>'int'),
    'labelSize'       => array('mandatory'=>true,  'type'=>'widthAndHeightFloat'),
//    'text'            => array('mandatory'=>true,  'type'=>'string'),
    'paperSize'       => array('mandatory'=>false, 'type'=>'withAndHeightFloat'),
    'textSize'        => array('mandatory'=>false, 'type'=>'float'),
    'textFont'        => array('mandatory'=>false, 'type'=>'string'),
    'labelGapX'       => array('mandatory'=>false, 'type'=>'float'),
    'labelGapY'       => array('mandatory'=>false, 'type'=>'float'),
    'correctionX'     => array('mandatory'=>false, 'type'=>'float'),
    'correctionY'     => array('mandatory'=>false, 'type'=>'float'),
    'outline'         => array('mandatory'=>false, 'type'=>'bool'),
    'labelRadius'     => array('mandatory'=>false, 'type'=>'float'),
);

// Check the presence of mandatory parameters and the type of every parameter.

foreach ($availableParams as $paramName => $paramAttributes) {
    if (!array_key_exists($paramName, $params)) {
        if ($paramAttributes['mandatory']) {
            exit("Missing mandatory parameter: '$paramName'\n");
        } else {
            continue;
        }
    }

    $paramValue = $params[$paramName];
    switch ($paramAttributes['type']) {
        case 'widthAndHeightFloat':
            @list($width, $height) = explode('x', $paramValue, 2);
            if (!is_numeric($width) || !is_numeric($height)) {
                exit("Parameter '$paramName' has invalid widthXheight value: '$paramValue'\n");
            }
            break;
        case 'int':
            if (preg_match('/^[+-]?[0-9]+$/', $paramValue) !== 1) {
                exit("Parameter '$paramName' has invalid int value: '$paramValue'\n");
            }
            break;
        case 'float':
            if (!is_numeric($paramValue)) {
                exit("Parameter '$paramName' has invalid float value: '$paramValue'\n");
            }
            break;
        case 'bool':
            if (!in_array($paramValue, array('true', 'false'))) {
                exit("Parameter '$paramName' has invalid bool value: '$paramValue'\n");
            }
            break;
        case 'string':
            # No check needed.
            break;
    }
}

// Assign default values to undefined parameters.
function get_param($paramName, $defaultValue)
{
    global $params;
    return array_key_exists($paramName, $params) ? $params[$paramName] : $defaultValue;
}

//$svg = file_get_contents('phoi/tem-nanomic_4x2_bo-goc_111.svg');

list($paperSizeX, $paperSizeY) = explode('x', get_param('paperSize', '210x297'));
//list($paperSizeX, $paperSizeY) = explode('|', get_param('paperSize', '595.28|878.74'));
list($labelSizeX, $labelSizeY) = explode('x', $params['labelSize']);
$numberOfColumns =               @$params['numberOfColumns'] ? $params['numberOfColumns'] : ($paperSizeX/$labelSizeX);
$numberOfRows =                  @$params['numberOfRows'] ? $params['numberOfRows'] : 0;

$labelRadius =                   get_param('labelRadius', 0);
$labelGapX =                     get_param('labelGapX', 0);
$labelGapY =                     get_param('labelGapY', 0);
//$text =                          $svg;//$params['text'];
$textSize =                      get_param('textSize', 3);
$textFont =                      get_param('textFont', 'Arial');
$correctionX =                   get_param('correctionX', 0);
$correctionY =                   get_param('correctionY', 0);
$outline =                       get_param('outline', 'false');

$paperSizeX_old = $paperSizeX;
$paperSizeY_old = $paperSizeY;
$paperSizeX = ( $labelSizeX * $numberOfColumns  ) + $labelGapX*($numberOfColumns-1);
//$percent = ($paperSizeX*100)/$paperSizeX_old;
//$paperSizeY = ($paperSizeY+$labelGapY) / ($labelSizeY+1);
$paperSizeY = ( $labelSizeY * $numberOfRows ) + $labelGapY*($numberOfRows-1);

$matrixOffsetX = ($paperSizeX - $numberOfColumns*$labelSizeX - ($numberOfColumns-1)*$labelGapX) / 2;
$matrixOffsetY = ($paperSizeY - $numberOfRows*$labelSizeY - ($numberOfRows-1)*$labelGapY) / 2;

$labelSizeX = $labelSizeY = ($paperSizeX/$numberOfColumns) - (($numberOfColumns-1)*$labelGapX);
$radio = 97;
//qrcode
$w = $h = $labelSizeX * (97/100);
//$h = $labelSizeY;
$m = '0';
//$labelSizeY += 20;

$x= "3";
$y="0";

require_once('BaconQrCode/autoload_classmap.php');
require_once('BaconQrCode/autoload_function.php');
require_once('BaconQrCode/autoload_register.php');
//$renderer = new \BaconQrCode\Renderer\Image\Svg();
//$renderer->setHeight($h);
//$renderer->setWidth($w);
//$renderer->setMargin($m);

$curprg = basename(__FILE__);

define("MYSQLHOST", 'localhost');
define("MYSQLDATABASE", 'evs5_checkin');
define("MYSQLUSER", 'root');
define("MYSQLPASS", '');

//define("MYSQLHOST", '10.5.10.22:3306');
//define("MYSQLDATABASE", 'evs5');
//define("MYSQLUSER", 'u.evs5');
//define("MYSQLPASS", 'frmS@68NKvBFNJ');

include_once('../LogEvent.php');
include_once('../Strings.php');
include_once('../Msqli.php');
$mysql = Msqli::getInstance();
$sql = "select * from store";
$re = $mysql->setQuery( $sql );
$arItem = $mysql->getRow( $re );

$arText = $arStore = array();
//for( $i=0; $i<$limit; $i++) {
$i=0;
foreach($arItem as $k=>$item ) {
    $renderer = new \BaconQrCode\Renderer\Image\Svg();
    $renderer->setHeight($h);
    $renderer->setWidth($w);
    $renderer->setMargin($m);
    $writer = new \BaconQrCode\Writer($renderer);
//    $item['name'] = htmlentities(utf8_encode($item['name']));//iconv_get_encoding( $item['name'] );
//    $item['name'] = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $item['name']); ;//iconv_get_encoding( $item['name'] );
//    echo $item['name']."<br>";
//    echo $item['name']."<br>";
//    $utf32  = mb_convert_encoding( $item['name'], 'UTF-8', $encoding );
//    $length = mb_strlen( $utf32, 'UTF-8' );
//    $result = [];
//    for( $i = 0; $i < $length; ++$i )
//        $result[] = hexdec( bin2hex( mb_substr( $utf32, $i, 1, 'UTF-8' ) ) );
//    $item['name'] = join( '', $result);

    $tt = urlencode($item['id'] .' | '.$item['name'] .' | '.$item['phone']);
//    $tt = urlencode($item['id'] .' | '.mb_convert_encoding($item['name'], 'HTML-ENTITIES', "UTF-8") .' | '.$item['phone']);
    $tt = $writer->writeString($tt);
    $arText[] = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $tt);
    $arStore[$i] = $item;
    $i++;
}

$limit = @count($arText);
//die;
// Print SVG output.
//header('Content-Type: text/html; charset=utf-8');
header("Content-type: image/svg+xml");
//header("Content-type: image/svg+xml; charset=utf-8");
//die("<pre>".print_r($arText, 1)."</pre>");
print "<svg width='{$paperSizeX}mm' height='{$paperSizeY}mm' viewBox='0 0 {$paperSizeX} {$paperSizeY}' " .
    "xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink'>\n";
?>
    <style>
        .outline {
            fill: none;
            stroke: black;
            stroke-width: 0.1;
        }
    </style>

<?php for( $i=0; $i<$limit; $i++) { ?>
    <defs>
        <symbol id="label<?php echo $i;?>" overflow="visible">
            <?php
            if ($outline == 'true') {
                print "<rect class='outline' width='$labelSizeX' height='$labelSizeY' rx='$labelRadius' />\n";
            }
            print '<svg x="'.$x.'" y="'.$y.'">' . $arText[$i] . '</svg>\n';
//            print "<text text-anchor='middle' font-size='{$textSize}' x='".($x+20)."' y='".($y+$h)."'>".$arStore[$i]['name']."</text>\n";
            ?>
        </symbol>
    </defs>
<?php } ?>

<?php $i = 0;
for ($rowNumber = 0; $rowNumber < $numberOfRows && $i<$limit; $rowNumber++) { ?>
    <symbol id="row<?php echo $rowNumber;?>" overflow="visible">
        <?php
        for ($columnNumber = 0; $columnNumber < $numberOfColumns && $i<$limit; $columnNumber++) {
            printf("<use xlink:href='#label{$i}' x='%f' />\n", $columnNumber * ($labelSizeX + $labelGapX));
            $i++;
        }
        ?>
    </symbol>
<?php } ?>

<symbol id="page" overflow="visible">
    <?php
    for ($rowNumber = 0; $rowNumber < $numberOfRows; $rowNumber++) {
    printf("<use xlink:href='#row$rowNumber' y='%f' />\n", $rowNumber * ($labelSizeY + $labelGapY));
    }
    ?>
</symbol>

<?php
if ($outline == 'true') {
    print "<rect class='outline' x='$correctionX' y='$correctionY' width='$paperSizeX' height='$paperSizeY' />\n";
}
printf("<use xlink:href='#page' x='%f' y='%f' />\n", $matrixOffsetX+$correctionX, $matrixOffsetY+$correctionY);
?>
    </svg>
<?php
//file_put_contents('svg/img'.$index.'.svg', $text );
//@header('Content-Disposition: inline; filename="img_matrix.svg');
//@header("Content-Transfer-Encoding: binary");
//@readfile('img_matrix.svg');
//ob_end_flush();
?>