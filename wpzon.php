<?php
/*
Plugin URI: http://wpnicheground.blogspot.com
Plugin Name: wpzon Plugin for Wordpress
Description: Add products from the Amazon Marketplace.
Version: 1.3
Date: September 13th, 2012
Author: Lora 
/*
Licence: GNU General Public License v3.0
More info: http://www.gnu.org/copyleft/gpl.html
*/

function truncate($string, $limit, $break=".", $pad="") { 
    if(strlen($string) <= $limit) return $string;
    if (false !== ($breakpoint = strpos($string, $break, $limit))) {
      if($breakpoint < strlen($string) - 1) {
	    $string = substr($string, 0, $breakpoint) . $pad;
	  }
    }
    return $string;
  }

 

function wpzon_shortcode( $atts ) {
 extract(shortcode_atts(array('keywords' => '', 'sindex' => '', 'snode' => '', 'listing' => '', 'sort' => '', 'page' => '',  'country' => 'com', 'spec' => '0', 'asin' => '', 'col' => '1', 'descr' => '1',), $atts));
add_option( 'az_public', '' );
add_option( 'az_secret', '' );
add_option( 'az_atagcom', '' );
add_option( 'az_atagcouk', '' );
add_option( 'az_atagca', '' );
add_option( 'az_atagcn', '' );
add_option( 'az_atagfr', '' );
add_option( 'az_atagde', '' );
add_option( 'az_atagin', '' );
add_option( 'az_atagit', '' );
add_option( 'az_atagjp', '' );
add_option( 'az_atages', '' );
add_option( 'az_atagau', '' );
add_option( 'az_atagcombr', '' );
add_option( 'az_atagcommx', '' );
add_option( 'az_col', '' ); 
add_option( 'az_pricecol', '' ); 

$publickey = get_option('az_public');
$secretkey = get_option('az_secret');
$atagcom = get_option('az_atagcom');
$atagcouk = get_option('az_atagcouk');
$atagca = get_option('az_atagca');
$atagcn = get_option('az_atagcn');
$atagfr = get_option('az_atagfr');
$atagde = get_option('az_atagde');
$atagin = get_option('az_atagin');
$atagit = get_option('az_atagit');
$atagjp = get_option('az_atagjp');
$atages = get_option('az_atages');
$atagau = get_option('az_atagau');
$atagcombr = get_option('az_atagcombr');
$atagcommx = get_option('az_atagcommx');
$pricecol = get_option('az_pricecol');

if ($country == "com" ){ $atag = $atagcom; }
if ($country == "co.uk" ){ $atag = $atagcouk; }
if ($country == "in" ){ $atag = $atagin; }
if ($country == "es" ){ $atag = $atages; }
if ($country == "fr" ){ $atag = $atagfr; }
if ($country == "jp" ){ $atag = $atagjp; }
if ($country == "com.mx" ){ $atag = $atagcommx; }
if ($country == "cn" ){ $atag = $atagcn; }
if ($country == "com.br" ){ $atag = $atagcombr; }
if ($country == "it" ){ $atag = $atagit; }
if ($country == "de" ){ $atag = $atagde; }
if ($country == "ca" ){ $atag = $atagca; }
if ($country == "au" ){ $atag = $atagau; }

if ($pricecol == "") {$pricecol = "CD2323";}
else {$pricecol = $pricecol;}


if ($spec == "0") {
$time = gmdate("Y-m-d\TH:i:s\Z");
$uri = 'Operation=ItemSearch&Condition=All&Availability=Available&ResponseGroup=Large,EditorialReview,ItemAttributes,OfferFull,Offers&Version=2011-08-01';
$uri .= "&Keywords=" . urlencode($keywords);
$uri .= "&SearchIndex=$sindex";
$uri .= "&BrowseNode=$snode";
$uri .= "&Sort=$sort";
$uri .= "&ItemPage=$page";
$uri .= "&AWSAccessKeyId=$publickey";
$uri .= "&AssociateTag=$atag";
$uri .= "&Timestamp=$time";
$uri .= "&Service=AWSECommerceService";
$uri = str_replace(',','%2C', $uri);
$uri = str_replace(':','%3A', $uri);
$uri = str_replace('*','%2A', $uri);
$uri = str_replace('~','%7E', $uri);
$uri = str_replace('+','%20', $uri);
$sign = explode('&',$uri);sort($sign);$host = implode("&", $sign);
if ($country == "jp") {$host = "GET\necs.amazonaws.".$country."\n/onca/xml\n".$host;}
else {$host = "GET\nwebservices.amazon.".$country."\n/onca/xml\n".$host;}
$signed = urlencode(base64_encode(hash_hmac("sha256", $host, $secretkey, True)));
$uri .= "&Signature=$signed";
if ($country == "jp") {$uri = "http://ecs.amazonaws.".$country."/onca/xml?".$uri;}
else {$uri = "http://webservices.amazon.".$country."/onca/xml?".$uri;}
}

elseif ($spec == "1") {
$time = gmdate("Y-m-d\TH:i:s\Z");
$uri = 'Operation=ItemLookup&Condition=All&Availability=Available&ResponseGroup=Large,EditorialReview,ItemAttributes,OfferFull,Offers&Version=2011-08-01';
$uri .= "&ItemId=$asin";
$uri .= "&AWSAccessKeyId=$publickey";
$uri .= "&AssociateTag=$atag";
$uri .= "&Timestamp=$time";
$uri .= "&Service=AWSECommerceService";
$uri = str_replace(',','%2C', $uri);
$uri = str_replace(':','%3A', $uri);
$uri = str_replace('*','%2A', $uri);
$uri = str_replace('~','%7E', $uri);
$uri = str_replace('+','%20', $uri);
$sign = explode('&',$uri);sort($sign);$host = implode("&", $sign);
if ($country == "jp") {$host = "GET\necs.amazonaws.".$country."\n/onca/xml\n".$host;}
else {$host = "GET\nwebservices.amazon.".$country."\n/onca/xml\n".$host;}
$signed = urlencode(base64_encode(hash_hmac("sha256", $host, $secretkey, True)));
$uri .= "&Signature=$signed";
if ($country == "jp") {$uri = "http://ecs.amazonaws.".$country."/onca/xml?".$uri;}
else {$uri = "http://webservices.amazon.".$country."/onca/xml?".$uri;}
}






$ch = curl_init($uri); 
curl_setopt($ch, CURLOPT_HEADER, false); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$xml = curl_exec($ch); 
curl_close($ch); 

$pxml = simplexml_load_string($xml); 

$breaklist=0;
$all = &$pxml->Items->Item;
$param = array();
for($count = count($all)-1; $count >= 0; --$count) { 
$param[(string)$all[$count]->ItemAttributes->Title] = &$all[$count];}

foreach ($pxml->Items->Item as $item){

$link = $item->DetailPageURL;
$sprice = $item->Offers->Offer->OfferListing->Price->FormattedPrice;
$lprice = $item->ItemAttributes->ListPrice->FormattedPrice;

$avab =$item->Offers->Offer->OfferListing->Availability;
$img = $item->SmallImage->URL;


if ($country == "com" && $sprice == "")  {$seed = "See Details >>"; $sprice = "Various"; } elseif ($country == "com" && $sprice == $sprice) {$sprice=$sprice; $seed = "See Details >>";}
if ($country == "in" && $sprice == "")  {$seed = "See Details >>"; $sprice = "Various"; } elseif ($country == "in" && $sprice == $sprice) {$sprice=$sprice; $seed = "See Details >>";}
if ($country == "ca" && $sprice == "")  {$seed = "See Details >>"; $sprice = "Various"; } elseif ($country == "ca" && $sprice == $sprice) {$sprice=$sprice; $seed = "See Details >>";}
if ($country == "au" && $sprice == "")  {$seed = "See Details >>"; $sprice = "Various"; } elseif ($country == "au" && $sprice == $sprice) {$sprice=$sprice; $seed = "See Details >>";}
if ($country == "co.uk" && $sprice == "")  {$seed = "See Details >>"; $sprice = "Various"; } elseif ($country == "co.uk" && $sprice == $sprice) {$sprice=$sprice; $seed = "See Details >>";}

if ($country == "fr" &&  $sprice == "") {$seed = "En Savoir +"; $sprice = "Voir les Prix";} elseif ($country == "fr" &&  $sprice == $sprice) {$sprice=$sprice; $seed = "En Savoir +";}
if ($country == "jp" &&  $sprice == "") {$seed = "その他の情報を見る >>"; $sprice = "価格を見る";} elseif ($country == "jp" &&  $sprice == $sprice) {$sprice=$sprice; $seed = "その他の情報を見る >>";}
if ($country == "de" && $sprice == "") {$seed = "Mehr Infos >>"; $sprice = "Siehe Preisliste";} elseif ($country == "de" && $sprice == $sprice) {$sprice=$sprice; $seed = "Mehr Infos >>";}
if ($country == "it" && $sprice == "") {$seed = "Dettagli >>"; $sprice = "Vedere il Prezzo";} elseif ($country == "it" && $sprice == $sprice) {$sprice=$sprice; $seed = "Dettagli >>";}
if ($country == "es" && $sprice == "") {$seed = "Más información >>"; $sprice = "Ver los Precios";} elseif ($country == "es" && $sprice == $sprice) {$sprice=$sprice; $seed = "Más información >>";}
if ($country == "com.br" && $sprice == "") {$seed = "Más información >>"; $sprice = "Ver los Precios";} elseif ($country == "com.br" && $sprice == $sprice) {$sprice=$sprice; $seed = "Más información >>";}
if ($country == "com.mx" && $sprice == "") {$seed = "Más información >>"; $sprice = "Ver los Precios";} elseif ($country == "com.mx" && $sprice == $sprice) {$sprice=$sprice; $seed = "Más información >>";}
if ($country == "cn" && $sprice == "") {$seed = "详细信息 >>"; $sprice = "查看价格";} elseif ($country == "cn" && $sprice == $sprice) {$sprice=$sprice; $seed = "详细信息 >>";}


$title = $item->ItemAttributes->Title;
$title = preg_replace('`\[[^\]]*\]`','',$title);
$title = preg_replace('`\([^\]]*\)`','',$title);
$title = str_replace("\"","",$title);
$title = truncate($title, 25, " ");

$titlel = $item->ItemAttributes->Title;
$titlel = preg_replace('`\[[^\]]*\]`','',$titlel);
$titlel = preg_replace('`\([^\]]*\)`','',$titlel);
$titlel = str_replace("\"","",$titlel);
$titlel = truncate($titlel, 60, " ");


$desc = $item->EditorialReviews->EditorialReview->Content ;
$desc = preg_replace("/<img[^>]+\>/i", " ", $desc); 
$desc = strip_tags($desc);
$desc = substr($desc, 0, 270);

if ($desc == "") {$desc = "";} else { $desc = $desc . "...";}
$avab = truncate($avab, 69, " ");


if ($img == "") {$content .= '';}

else{
if ($col == "1") {
if ($descr == "1") {

$content .= '<div style="width:100%">
<div style="float:left;width:15%;">
<img src="'.$img.'" style="margin:0;padding:0;float:left;border:none;" /></div>
<div style="float:left;margin:0px 50px 90px 0;width:75%;"><a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;">'.$titlel.'</a><br><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.' </span><strike style="color:#444;"><span style="font-size:13px;text-decoration:none;font-weight:500;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;">'.$avab.'</div><a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;">'.$seed.'</a></div></div>';
}
else {
$content .= '<div style="width:100%">
<div style="float:left;width:15%;">
<img src="'.$img.'" style="margin:0;padding:0;float:left;border:none;" /></div>
<div style="float:left;margin:0px 50px 90px 0;width:75%;"><a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;">'.$titlel.'</a><br><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.' </span> <strike style="color:#444;"><span style="font-size:13px;text-decoration:none;font-weight:500;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;">'.$avab.'</div><a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;">'.$seed.'</a></div></div>';}}
elseif ($col == "2") {
if ($descr == "1") {
if(($i % 2)==0){

$content .= '<div style="margin-bottom:140px;float:left;width:48%;margin-right:4%;">
<div style="width:250px;height:97px;" >
<img src="'.$img.'"  style="margin:0;padding:0 0 20px 30px;border:none;" /></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both"><span style="color: #'.$pricecol.';font-size:15px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:13px;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;">'.$avab.'</div></div></div>';
}

else {
$content .= '<div style="margin-bottom:140px;float:left;width:48%;margin-right:0%;">
<div style="width:250px;height:97px;" >
<img src="'.$img.'"  style="margin:0;padding:0 0 20px 30px;border:none;" /></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both"><span style="color: #'.$pricecol.';font-size:15px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:13px;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;">'.$avab.'</div></div></div>';
}}
else {
if(($i % 2)==0){

$content .= '<div style="margin-bottom:140px;float:left;width:48%;margin-right:4%;">
<div style="width:250px;height:97px;" >
<img src="'.$img.'"  style="margin:0;padding:0 0 20px 30px;border:none;" /></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both"><span style="color: #'.$pricecol.';font-size:15px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:13px;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;">'.$avab.'</div></div></div>';
}

else {
$content .= '<div style="margin-bottom:140px;float:left;width:48%;margin-right:0%;">
<div style="width:250px;height:97px;" >
<img src="'.$img.'"  style="margin:0;padding:0 0 20px 30px;border:none;" /></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both"><span style="color: #'.$pricecol.';font-size:15px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:13px;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;">'.$avab.'</div></div></div>';
}}
$i++;
		
if(($i % 2)==0){$content .= '<div style="clear:both"></div>';}
}

elseif ($col == "3") {
if ($descr == "1") {
if (($i % 3)==0) {


$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:6%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}

elseif (($i % 3)==1) {
$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:6%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}

else{
$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:0%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><br>'.$desc.'<div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}
}
else {
if (($i % 3)==0) {

$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:6%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}

elseif (($i % 3)==1) {
$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:6%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}

else{
$content .= '<div style="margin-bottom:130px;float:left;width:29%;margin-right:0%;">
<div style="width:200px;height:97px;" >
<a href="'.$link.'" rel="nofollow"><img src="'.$img.'"  style="margin:0;padding:0px 0 0 30px;border:none;" /></a></div>
<a href="'.$link.'" rel="nofollow" style="text-decoration:none;font-weight:600;float:left;">'.$title.'</a>
<div style="float:left;margin:3px 0 0px 0;clear:both;"><span style="color: #'.$pricecol.';font-size:14px;text-decoration:none;font-weight:600;"> '.$sprice.'</span>  <strike style="color:#444;"><span style="font-size:12px;font-weight:500;;">'.$lprice.'</span></strike><div style="font-size:12px;clear:both;color:#777;">'.$avab.'</div></div></div>';
}
}
$i++;
		
if(($i % 3) == 0 ){$content .= '<div style="clear:both"></div>';}

}


$breaklist++; 
if ($breaklist >=$listing){break;}
}
}
return $content;
}

function add_wpzon_panel() {
if (function_exists('add_options_page')) {
add_options_page('wpzon', 'wpzon', 8, 'wpzon', 'wpzon_admin_panel');
}
}

function wpzon_admin_panel() { if ($_POST["az_\165pda\x74e\144"]){
update_option('az_public',$_POST['az_public']); 
update_option('az_secret',$_POST['az_secret']); 
update_option('az_atagcom',$_POST['az_atagcom']); 
update_option('az_atagcouk',$_POST['az_atagcouk']); 
update_option('az_atagde',$_POST['az_atagde']); 
update_option('az_atagit',$_POST['az_atagit']); 
update_option('az_atagfr',$_POST['az_atagfr']); 
update_option('az_atagjp',$_POST['az_atagjp']); 
update_option('az_atagcommx',$_POST['az_atagcommx']); 
update_option('az_atagcn',$_POST['az_atagcn']); 
update_option('az_atagcombr',$_POST['az_atagcombr']); 
update_option('az_atages',$_POST['az_atages']); 
update_option('az_atagau',$_POST['az_atagau']); 
update_option('az_atagca',$_POST['az_atagca']); 
update_option('az_atagin',$_POST['az_atagin']); 


echo '<div id="message" style="padding:2px 2px 2px 4px; font-size:12px;" class="updated"><strong>' . Updated . '</strong></div>';}?>

	<div class="wrap">
	<div style="width:99%; height:1170px;">
<div style="float:left;width:65%;margin-right:4%;">
	<h3 style="color:#0066cc;">WpZon Options</h3>	
	<form method="post" id="cj_options">
		<table cellspacing="10" cellpadding="5" > 
				
<tr valign="top">
<td width="17%"><strong>AWS Access Key</strong></td>
<td><input type="text" name="az_public" id="az_public" value="<?php echo get_option('az_public');?>" maxlength="300" style="width:400px;" /><p>To get your keys in your Amazon Associates account go to Product Advertising Api (sidebar) -> Manage Your Account -> Access Identifiers.<br><font style="color:#D3133E;">Please make sure that there are no spaces before or after the numbers.</font></td>
</tr>					
<tr valign="top">
<td><strong>AWS Secret Access Key</strong></td>
<td><input type="text" name="az_secret" id="az_secret" value="<?php echo get_option('az_secret');?>" maxlength="300" style="width:400px;" /></br></td>
</tr>
<tr valign="top">
<td><strong>Tracking ID <font style="font-size:10px; color:#555;">(*You will have to apply to each of the countries Associates separately)</font></strong></td>
<td><table>
<tr><td width="20"> US: <input type="text" name="az_atagcom" id="az_atagcom" value="<?php echo get_option('az_atagcom');?>" maxlength="40"/></td></tr>
<tr><td width="20"> United Kingdom: <input type="text" name="az_atagcouk" id="az_atagcouk" value="<?php echo get_option('az_atagcouk');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Australia: <input type="text" name="az_atagau" id="az_atagau" value="<?php echo get_option('az_atagau');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Canada:  <input type="text" name="az_atagca" id="az_atagca" value="<?php echo get_option('az_atagca');?>" maxlength="40"/></td></tr>
<tr><td width="30"> China: <input type="text" name="az_atagcn" id="az_atagcn" value="<?php echo get_option('az_atagcn');?>" maxlength="40"/></td></tr>
<tr><td width="30"> France:  <input type="text" name="az_atagfr" id="az_atagfr" value="<?php echo get_option('az_atagfr');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Germany: <input type="text" name="az_atagde" id="az_atagde" value="<?php echo get_option('az_atagde');?>" maxlength="40"/></td></tr>
<tr><td width="30"> India:  <input type="text" name="az_atagin" id="az_atagin" value="<?php echo get_option('az_atagin');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Italy:  <input type="text" name="az_atagit" id="az_atages" value="<?php echo get_option('az_atagit');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Japan:  <input type="text" name="az_atagjp" id="az_atagjp" value="<?php echo get_option('az_atagjp');?>" maxlength="40"/></td></tr>
<tr><td width="30"> Spain:  <input type="text" name="az_atages" id="az_atages" value="<?php echo get_option('az_atages');?>" maxlength="40"/></td></tr>

</table>
	




<tr valign="top">
<td><strong>Price Color</strong></td>
<td><input type="text" name="az_pricecol" id="az_pricecol" value="<?php echo get_option('az_pricecol');?>" maxlength="6" style="width:100px;" /><p>Enter color code (6 characters). For example <strong>FFA500</strong> for orange or <strong>000000</strong> for black. You can find all the color codes <a href="http://quackit.com/html/html_color_codes.cfm" target="_blank">here</a> . *If left blank will be automaticaly set to red</br></td>
</tr>


		</table>
		<p class="submit"><input type="submit" name="az_updated" value="Update Settings &raquo;" /></p>
		
</p>

</form>
</div>
<div style="float:right;width:20%;margin-right:10%;">
			<h3 style="color:#0066cc;font-size:19px;">Support the World</h3>
<a href="http://www.savethechildren.org/site/c.8rKLIXMGIpI4E/b.6146369/k.95B8/Ways_To_Give.htm" target="_blank" ><img border="0" src="http://3.bp.blogspot.com/-0zr4XT0-Uz0/UKvll0FDEPI/AAAAAAAAAiU/7Iwo0HoL_Eg/s1600/save+kids1.png" style="margin:0px 0 45px 0;" /></a>
<br>
<a href="http://www.doctorswithoutborders.com" target="_blank" ><img border="0" src="http://3.bp.blogspot.com/-r8JyKw1ZhaQ/UFMYK7A9V_I/AAAAAAAAAO4/tjeGBR6c0dU/s1600/doctorborders.jpg" width="270" height="127" /></a>


		</div>		</div>	
			
<div style="padding:0px 15px 15px 15px; margin:10px 0 0 0;border:3px solid #ccc;width:90%;">
<h3 style="color:#0066cc;">Please Read - How to use WpZon</h3>
<font style="font-size: 21px; color:brown;font-weight:bold;text-decoration:underline;">1. Display products based on keywords</font>
<p style="margin:30px 0 0 0;">Code format: <strong>[wpzon keywords="pressure cooker" sindex="Kitchen" snode="289825" sort="salesrank" listing="10" country="com" descr="1" col="2"]</strong></p>
<ul style="list-style:square;padding: 0 0 10px 30px;"><li><p style="margin:20px 0 0 0;"><strong>keywords</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = products you would like to display. Please do not use special characters, like &, @ etc.</li>
<li style="margin:10px 0 0 0;"><strong>sindex</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = Amazon category (also known as SearchIndex. These are: Electronics, Shoes, Kitchen etc. You can find them all <a href="http://docs.amazonwebservices.com/AWSECommerceService/2011-08-01/DG/APPNDX_SearchIndexParamForItemsearch.html" target="_blank">here</a> by country.</li>
<li style="margin:10px 0 0 0;"><strong>country</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = Amazon country code. If you want to advertise products from Amazon.com or Amazon.co.uk then set it to "com" or "co.uk"</li>
<li style="margin:10px 0 0 0;"><strong>snode</strong> <font style="color:#111;font-size:12px; font-weight:bold;">(*optional)</font> = Amazon subcategory (also known as BrowseNode). For instance if you want to narrow down results and display products from the Electronics category and Computer Accessories subcategory then the snode would be 172456. To find all the browsenodes go to <a href="http://www.findbrowsenodes.com" target="_blank">http://www.findbrowsenodes.com</a></li>
<li style="margin:10px 0 0 0;"><strong>sort</strong> <font style="color:#111;font-size:12px; font-weight:bold;">(*optional)</font> = sort products by price, bestselling, reviews etc.  For the sort values go to <a href="http://docs.amazonwebservices.com/AWSECommerceService/2011-08-01/DG/APPNDX_SortValuesArticle.html" target="_blank">Amazon Docs</a> then select your locale and category. For example for US Electronics you can set the sort value to one of the following: pmrank (Featured Items), salesrank (Bestselling), reviewrank (Avg review rank), price (Low to high), -price (High to low) or titlerank (Alphabetical: A to Z)</li>
<li style="margin:10px 0 0 0;"><strong>listing</strong> <font style="color:#111;font-size:12px; font-weight:bold;">(*optional)</font> = number of products you would like to display (from 1 to 10) Amazon Api only returns a maximum of 10 products per call.</li>
<li style="margin:10px 0 0 0;"><strong>descr</strong>  <font style="color:#111;font-size:12px; font-weight:bold;">(*optional)</font> = Show product description. Set it to "1" to display description, set it to "0" to not display anything.</li>
<li style="margin:10px 0 0 0;"><strong>col</strong> <font style="color:#111;font-size:12px; font-weight:bold;">(*optional)</font>= The number of columns. "1", "2" or "3"</li>
</ul>

<br style="margin:20px 0 30px 0;"><font style="font-size: 21px; color:brown;font-weight:bold;text-decoration:underline;margin:10px 0 30px 0;">2. Display products based on Asin</font>
<br style="margin:30px 0 30px 0;">If you want to display specific products then you can add an Asin.
In this case the code will look like:
<br><strong>[wpzon  spec="1" asin="B00006ISG6,B0000717AU" listing="2"]</strong>

<ul style="list-style:square;padding: 0 0 10px 30px;">
<li style="margin:10px 0 0 0;"><p style="margin:20px 0 0 0;"><strong>spec</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = You must set it to "1"</li>
<li style="margin:10px 0 0 0;"><strong>asin</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = The Asin number of the product. You can find it on the product page under Product Details.  You can add up to 10 Asin numbers separated by commas and no space between them. </li>
<li style="margin:10px 0 0 0;"><strong>country</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = Amazon country code. If you want to show products from Amazon.de or Amazon.ca set it to "de" or "ca"</li>
<li style="margin:10px 0 0 0;"><strong>listing</strong> <font style="color:red;font-size:12px; font-weight:bold;">(*required)</font> = The number of products you want to display.</li></ul>
<p>As an illustration the following shortcode: 
<br><strong>[wpzon keywords="pressure cooker" sindex="Kitchen" snode="289825" sort="salesrank" listing="8"]</strong>
<br>will show 8 pressure cookers from the Kitchen category, Pressure Cookers subcategory(289825) sorted by bestselling.<p>


<p style="margin:30px 0 30px 0;font-size:15px;"><strong>For feature requests and more help <a href="http://wpnicheground.blogspot.com/2010/03/free-amazon-wordpress-plugin.html" target="_blank">visit plugin site</a></strong></p></td>
</div>
	


	</div>
<?php
}
add_shortcode('wpzon', 'wpzon_shortcode');
add_action('admin_menu', 'add_wpzon_panel'); ?>