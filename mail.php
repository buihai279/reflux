<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 最終更新日2014/12/12
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------
//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "index_reflux.html";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "株式会社アピカル <info@apical.jp>"; 

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "Eメール";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "php-factory.net";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "ホームページからお問合せ受付";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 0;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "http://xxx.xxxxxxxxx/thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 0;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです。 
配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。*/
$require = array('お名前','Email');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 0;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "【アピカル】お問合せ受け付けました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
株式会社○○○○　佐藤太郎
〒150-XXXX 東京都○○区○○ 　○○ビル○F　
TEL：03- XXXX - XXXX 　FAX：03- XXXX - XXXX
携帯：090- XXXX - XXXX 　
E-mail:xxxx@xxxx.com
URL: http://www.php-factory.net/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 0;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('電話番号','金額');


//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}
if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
	
	//差出人に届くメールをセット
	if($remail == 1) {
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット

	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($userMail,$post_mail,$BccMail,$to);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";

	mail($to,$subject,$adminBody,$header);
	if(!empty($post_mail)){
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
		mail($post_mail,$re_subject,$userBody,$reheader);
	}
}
else if($confirmDsp == 1){ 

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>確認画面</title>
<?php getAsset(); ?>
<style type="text/css">
	body, html {
	    background-color: #eeb8cb!important;
	    margin: 0 auto!important;
	    font-size: 13px;
	    line-height: 27px;
	}

	/* 自由に編集下さい */
	#formWrap {
		width:1000px;
	    background-color: white !important;
		margin:0 auto;
		color:#555;
		padding: 30px;
	}
	table.formTable{
		width:100%;
		margin:0 auto;
		border-collapse:collapse;
	}
	table.formTable td,table.formTable th{
		border:1px solid #ccc;
		padding:10px;
	}
	table.formTable th{
		width:30%;
		font-weight:normal;
		background:#efefef;
		text-align:left;
	}
	p.error_messe{
		margin:5px 0;
		color:red;
	}
	.middle-button {
	    border: none;
	    border-radius: 5px;
	    color: #ffffff;
	    font-weight: bold;
	    font-family: NotoSansJPBold;
	    font-size: 17px;
	    height: 40px;
	    padding: 0 15px;
	    background: #e072a1;
	    background: -webkit-linear-gradient(#e072a1,#de6b9c,#cd3e7e);
	    background: -o-linear-gradient(#e072a1,#de6b9c,#cd3e7e);
	    background: -moz-linear-gradient(#e072a1,#de6b9c,#cd3e7e);
	    background: linear-gradient(#e072a1,#de6b9c,#cd3e7e);
	    opacity: 1;
	}
	.middle-button:hover {
	    opacity: .5;
	    cursor: pointer;
	}
	
#footer a:hover {
    text-decoration: none !important;
    color: #fff;
    display: block;
}
</style>
</head>
<body>
<?php getHeader(); ?>
<!-- ▲ Headerやその他コンテンツなど　※自由に編集可 ▲-->
<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
<div id="formWrap">
<?php if($empty_flag == 1){ ?>
<div align="center">
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<?php echo $errm; ?><br /><br /><input type="button" class="middle-button" value=" 前画面に戻る " onClick="history.back()">
</div>
<?php }else{ ?>
<h3>確認画面</h3>
<p align="center">以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="POST">
<table class="formTable">
<?php echo confirmOutput($_POST);//入力内容を表示?>
</table>
<p align="center" style="margin-top: 30px"><input type="hidden" name="mail_set" value="confirm_submit">
<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']);?>">
<input type="submit" class="middle-button" value="　送信する　">
<input type="button" class="middle-button" value="前画面に戻る" onClick="history.back()"></p>
</form>
<?php } ?>
</div><!-- /formWrap -->
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
<?php getFooter(); ?>
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>完了画面</title>
<?php getAsset(); ?>
<style type="text/css">
	body, html {
    background-color: #eeb8cb!important;
    margin: 0 auto!important;
}
.text-notify {
	width:1000px;
    background-color: white !important;
	margin:0 auto;
	padding: 40px;
}
#footer{
	line-height: 27px !important;
}
#footer a:hover {
    text-decoration: none !important;
    color: #fff;
    display: block;
}
</style>
</head>
<body>
<?php getHeader(); ?>
<div align="center" class="text-notify">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" class="middle-button" value=" 前画面に戻る " onClick="history.back()">
</div>
<?php getFooter(); ?>
</body>
</html>
<?php }else{ ?>
		お問合せありがとうございます。<br />
		内容を確認次第、3営業日以内にご連絡させていただきますので、今しばらくお待ちください。<br/>※もし期日を過ぎても連絡がない場合、大変お手数ですが
		　メールフォーム、もしくはお電話で再度ご連絡ください。<br/>
<a href="<?php echo $site_top ;?>">トップページへ戻る&raquo;</a>
</div>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
<?php getFooter(); ?>
</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	if($empty_flag == 1){ ?>
<div align="center"><h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4><div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" class="middle-button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php 
	}else{ header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	global $hankaku,$hankaku_array;
	$resArray = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){ 
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');
			
		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		
		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		if($out != "confirm_submit" && $key != "httpReferer") {
			$resArray .= "【 ".h($key)." 】 ".h($out)."\n";
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr){
	global $hankaku,$hankaku_array;
	$html = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){ 
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');
			
		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);
		
		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		
		$html .= "<tr><th>".$key."</th><td>".$out;
		$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
		$html .= "</td></tr>\n";
	}
	return $html;
}

//全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array){
	global $encode;
	if(is_array($hankaku_array) && function_exists('mb_convert_kana')){
		foreach($hankaku_array as $hankaku_array_val){
			if($key == $hankaku_array_val){
				$out = mb_convert_kana($out,'a',$encode);
			}
		}
	}
	return $out;
}
//配列連結の処理
function connect2val($arr){
	$out = '';
	foreach($arr as $key => $val){
		if($key === 0 || $val == ''){//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
			$key = '';
		}elseif(strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)){
			$val = number_format($val);//金額の場合には3桁ごとにカンマを追加
		}
		$out .= $val . $key;
	}
	return $out;
}

//管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
	$header = '';
	if($userMail == 1 && !empty($post_mail)) {
		$header="From: $post_mail\n";
		if($BccMail != '') {
		  $header.="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$post_mail."\n";
	}else {
		if($BccMail != '') {
		  $header="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$to."\n";
	}
		$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp){
	$adminBody="ホームページより、お問合せがありました。\n\n";
	$adminBody .="---------------------------------------------------------------------\n\n";
	$adminBody.="送信日時                     ：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody.="差出人ホスト                : ".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody.="件名　　　　　　　　：ホームページからお問合せ受付"."\n";
	$adminBody.="差出人名                      : ".$_POST['お名前']."\n";
	$adminBody.="差出人メールアドレス ：".$_POST['Eメール']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="お名前"."\n";
	$adminBody.=$_POST['お名前']."\n";
	$adminBody.="ふりがな"."\n";
	$adminBody.=$_POST['ふりがな']."\n";
	$adminBody.="ふりがな"."\n";
	$adminBody.=$_POST['ふりがな']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="種別"."\n";
	$adminBody.=$_POST['種別']."\n";
	$adminBody.="\n--------------------------------------------------------------------\n\n";
	$adminBody.="Eメール"."\n";
	$adminBody.=$_POST['Eメール']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="職業"."\n";
	$adminBody.=$_POST['職業']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="職業"."\n";
	$adminBody.=$_POST['職業']."\n";
	$adminBody.=$_POST['職業2']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="職種"."\n";
	$adminBody.=$_POST['職種']."\n";
	$adminBody.=$_POST['職種2']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="法人名"."\n";
	$adminBody.=$_POST['法人名']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="部署名"."\n";
	$adminBody.=$_POST['部署名']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="郵便番号"."\n";
	$adminBody.=$_POST['郵便番号']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="都道府県"."\n";
	$adminBody.=$_POST['都道府県']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="市区町村"."\n";
	$adminBody.=$_POST['市区町村']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="番地・ビル"."\n";
	$adminBody.=$_POST['番地・ビル']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="お電話番号"."\n";
	$adminBody.=$_POST['お電話番号']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="お電話連絡が可能な時間帯"."\n";
	$adminBody.=$_POST['お電話連絡が可能な時間帯']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="ご質問・お問合せ区分"."\n";
	if (isset($_POST['ご質問・お問合せ区分'])){
		$adminBody.=$_POST['ご質問・お問合せ区分']."\n";
	}else{
		$adminBody.="\n";
	};
	if (isset($_POST['項目に無いお問い合わせ区分'])){
		$adminBody.=$_POST['項目に無いお問い合わせ区分']."\n";
	};
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	$adminBody.="ご質問内容"."\n";
	$adminBody.=$_POST['ご質問内容※']."\n";
	$adminBody.="\n---------------------------------------------------------------------\n\n";
	if($mailFooterDsp == 1) $adminBody.= $mailSignature;
	// echo $adminBody;die();
	return mb_convert_encoding($adminBody,"JIS",$encode);
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
	$reheader = "From: ";
	if(!empty($refrom_name)){
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != $encode){
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	}else{
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
	$userBody = '';
	if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody.= $remail_text;
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.=$_POST['お名前']."様\n";
	$userBody.="このたびは、株式会社アピカルへお問合せいただきありがとうございました。\n";
	$userBody.="以下の内容で承りました。\n\n\n\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="お名前\n";
	$userBody.=$_POST['お名前']."\n";
	$userBody.="ふりがな\n";
	$userBody.=$_POST['ふりがな']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="種別\n";
	$userBody.=$_POST['種別']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="Eメール\n";
	$userBody.=$_POST['Eメール']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="職業\n";
	$userBody.=$_POST['職業']."\n";
	$userBody.=$_POST['職業2']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="職種\n";
	$userBody.=$_POST['職種']."\n";
	$userBody.=$_POST['職種2']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="法人名\n";
	$userBody.=$_POST['法人名']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="部署名\n";
	$userBody.=$_POST['部署名']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="郵便番号\n";
	$userBody.=$_POST['郵便番号']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="都道府県\n";
	$userBody.=$_POST['都道府県']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="市区町村\n";
	$userBody.=$_POST['市区町村']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="番地・ビル\n";
	$userBody.=$_POST['番地・ビル']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="お電話番号\n";
	$userBody.=$_POST['お電話番号']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="お電話連絡が可能な時間帯\n";
	$userBody.=$_POST['お電話連絡が可能な時間帯']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="ご質問・お問合せ区分\n";
	if (isset($_POST['ご質問・お問合せ区分'])){
		$userBody.=$_POST['ご質問・お問合せ区分']."\n";
	}else{
		$userBody.="\n";
	};
	if (isset($_POST['項目に無いお問い合わせ区分'])){
		$userBody.=$_POST['項目に無いお問い合わせ区分']."\n";
	};
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="ご質問内容\n";
	$userBody.=$_POST['ご質問内容※']."\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="内容を確認次第、3営業日以内ご連絡させていただきますので、今しばらくお待ちください。\n";
	$userBody.="※もし期日を過ぎても連絡がない場合、大変お手数ですが\n";
	$userBody.="Eメール"."<info@apical.jp>、もしくはお電話でご連絡ください。\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="株式会社アピカル\n";
	$userBody.="\n---------------------------------------------------------------------\n\n";
	$userBody.="福岡市中央区六本松2丁目12-25ベルヴィ六本松5Ｆ\n";
	$userBody.="URL: http://www.apical.jp/\n";
	$userBody.="TEL: 092-741-1833(代表)\n";
	$userBody.="FAX: 092-741-9580\n";
	// echo $userBody;die();

	if($mailFooterDsp == 1) $userBody.= $mailSignature;
	return mb_convert_encoding($userBody,"JIS",$encode);
}
//必須チェック関数
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal) {
				
				//連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}
						
					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				//デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
					$res['empty_flag'] = 1;
				}
				
				$existsFalg = 1;
				break;
			}
			
		}
		if($existsFalg != 1){
				$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}
	
	return $res;
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright(){
	echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';
}
function getFooter()
{
?>
	<section id="footer">
	    <div class="footer-top">
	        <div class="apical"><img src="assets/images/logo-footer.png" alt=""></div>
	        <div class="footer-hr-new"></div>
	        <div class="menu">
	            <div class="menu-col-1">
	                <div class="menu-header">
	                    <a>会社情報</a>
	                </div>
	                <div class="menu-content">
	                    <a href="/reflux/company.html">会社案内</a>
	                    <a href="/reflux/pp.html">プライバシーポリシー</a>
	                </div>
	            </div>
	            <div class="menu-col-2">
	                <div class="menu-header">
	                    <a>事業内容</a>
	                </div>
	                <div class="menu-content">
	                    <a href="/reflux/jigyousyo.html">事業所内託児施設</a>
	                    <a href="/reflux/tenponai.html">店舗内託児施設</a>
	                    <a href="/reflux/event.html">イベント保育</a>
	                    <a href="/reflux/jisseki.html">運営実績</a>
	                    <a href="/reflux/consul.html">開業・開設コンサル</a>
	                </div>
	            </div>
	            <div class="menu-col-3">
	                <div class="menu-header">
	                    <a>お問い合わせ</a>
	                </div>
	                <div class="menu-content">
	                    <a href="/reflux/kyujin.html">求人情報</a>
	                    <a href="/reflux/contact.html">コンタクト</a>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="footer-middle">
	        <div class="middle-menu">
	            <div class="col-middle-1">
	                <div class="middle-header">
	                    <a style="text-decoration: none ;margin-left: -10px; color: #fff">［本社］</a>
	                </div>
	                <div class="middle-content">
	                    <a><p>〒810-0044</p></a>
	                    <a><p>福岡市中央区六本松2丁目12-25</p></a>
	                    <a><p>ベルヴィ六本松5Ｆ</p></a>
	                    <a><p>TEL：092-741-1833（代表）</p></a>
	                </div>
	            </div>
	            <div class="col-middle-2">
	                <div class="middle-header" style="padding-left: 30px; color: #fff">
	                    <a style="text-decoration: none;color: #fff">［関西支店］</a>
	                </div>
	                <div class="middle-content" style="padding-left: 40px">
	                    <a><p>〒665-0003</p></a>
	                    <a><p>兵庫県宝塚市湯本町4-8</p></a>
	                    <a><p>グランディア ミ・アモーレ402</p></a>
	                    <a><p>TEL：0797-81-0500</p></a>
	                </div>
	            </div>
	            <div class="col-middle-3">
	                <div class="middle-header" style="padding-left: 30px; color: #fff">
	                    <a style=" text-decoration: none;color: #fff">［関東支店］</a>
	                </div>
	                <div class="middle-content" style="padding-left: 40px">
	                    <a><p>〒164-0012</p></a>
	                    <a><p>東京都中野区本町6-20-9</p></a>
	                    <a><p>ミツクニ新中野ビル4F</p></a>
	                    <a><p>TEL：03-5340-7914</p></a>
	                </div>
	            </div>
	            <div class="col-middle-4">
	                <div class="middle-header">
	                    <a style="text-decoration: none ;color: #fff; margin-left: -10px">［熊本支店］</a>
	                </div>
	                <div class="middle-content">
	                    <a><p>〒860-0072</p></a>
	                    <a><p>熊本市西区花園6-38-45</p></a>
	                    <a><p>TEL：096-356-5453</p></a>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="footer-last">
	        <center>Copyright © APICAL. All Rights Reserved.</center>
	    </div>
	</section>
	<a href="#" id="back-to-top" title="Back to top"></a>
	<!-- Libs Script -->
	<script type="text/javascript" src="assets/js/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/scroll-top.js"></script>
	<!-- Scrolling Nav JavaScript -->
	<script type="text/javascript" src="assets/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="assets/js/scrolling-nav.js"></script>
<?php
}
?>
<?php function getHeader()
{
?>
	<section id="header">
        <div class="logo">
            <a href="/reflux/index_reflux.html"><img src="assets/images/logo.png"></a>
        </div>
        <div class="main-menu">
            <a href="/reflux/kyujin.html">
                <div class="contact">
                    求人情報
                </div>
            </a>
            <a href="/reflux/contact.html">
                <div class="contact">
                    <i class="fa fa-envelope"></i>お問い合わせ
                </div>
            </a>
            <ul class="menu-list">
                <li class="item">
                    <img src="assets/images/menu-top.png" width="30" height="10">
                    <a href="/reflux/company.html">会社案内</a>
                </li>
                <li class="item">
                    <img src="assets/images/menu-top.png" width="30" height="10">
                    <a href="/reflux/pp.html">プライバシーポリシー</a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="scroll-menu">
            <ul>
                <li class="item-menu">
                    <i class="fa fa-play"></i>
                    <a href="/reflux/jigyousyo.html" class="active">事業所内託児施設</a>
                    <div class="hover-menu"></div>
                    <span></span>
                </li>
                <li class="item-menu">
                    <i class="fa fa-play" aria-hidden="true"></i>
                    <a href="/reflux/tenponai.html">店舗内託児施設</a>
                    <div class="hover-menu"></div>
                    <span></span>
                </li>
                <li class="item-menu">
                    <i class="fa fa-play" aria-hidden="true"></i>
                    <a href="/reflux/event.html">イベント保育</a>
                    <div class="hover-menu"></div>
                    <span></span>
                </li>
                <li class="item-menu">
                    <i class="fa fa-play" aria-hidden="true"></i>
                    <a href="/reflux/jisseki.html">運営実績</a>
                    <div class="hover-menu"></div>
                    <span></span>
                </li>
                <li class="item-menu">
                    <i class="fa fa-play" aria-hidden="true"></i>
                    <a href="/reflux/consul.html">開業・開設コンサル</a>
                    <div class="hover-menu"></div>
                    <span></span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="button-header">
            <a href="personal/index.html">
                <button class="middle-button">個人のお客様</button>
            </a>
            <div class="box-icon">
                <div class="box-icon-content"><a href=""><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a></div>
                <div class="box-icon-content"><a href=""><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a></div>
                <div class="box-icon-content"><a href=""><i class="fa fa-instagram fa-lg" aria-hidden="true"></i></a></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="line-top"></div>
        <div class="clearfix"></div>
    </section>
<?php
}

function getAsset()
{
?>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="shortcut icon" href="assets/images/apical_web_favicon_32-32.png">
<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/loc-style.css">
<link rel="stylesheet" href="assets/css/loi-style.css">
<link rel="stylesheet" href="assets/css/hung_style.css">
<link rel="stylesheet" href="assets/css/duong-style.css">
<link rel="stylesheet" href="assets/css/scrolling-nav.css">
<?php
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>