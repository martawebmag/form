<?php
session_start();	
if(!preg_match('/^[a-zA-Z0-9.\-_]+\@dzielo.pl$/D', $_POST['email']))
{
session_destroy();
header('Location: https://obozy.dzielo.pl/nowy_studenci/studenci/domena.html');
}
else
{

if(!preg_match('/^[0-9]{11}$/', $_POST['pesel']))
{
session_destroy();
header('Location: https://obozy.dzielo.pl/nowy_studenci/studenci/blad.html');
}
else
{

if (!preg_match('/^[a-z0-9]{9,16}$/', $_POST['phone'])) 
{
session_destroy();
header('Location: https://obozy.dzielo.pl/nowy_studenci/studenci/blad.html');
}
else
{



	if ($_POST['name']=="" || $_POST['surname']=="" ||
	$_POST['pesel']=="" || $_POST['data']=="" ||
	$_POST['email']=="" || $_POST['email2']=="" || $_POST['phone']=="" || 
	$_POST['post']=="" || $_POST['postcode']=="" ||
	$_POST['city']=="" || $_POST["wspolnota"] == "-" ||
	$_POST['dieta']=="-" || $_POST['homeNumber']=="" ||
	$_POST['regulamin']=="" || $_POST['szpital']=="" ||
	$_POST['plec']=="-" || $_POST['elektronika']==""|| 
	$_POST['wizerunek']=="" || $_POST['tshirt']=="-" || $_POST['rodo']=="" ) {

session_destroy();
header('Location: https://obozy.dzielo.pl/nowy_studenci/studenci/blad.html');
}


require_once "connect.php";

 
 $db=mysqli_connect($adres_ip_serwera_mysql_z_baza_danych, $login_bazy_danych, $haslo_bazy_danych);

     
    if (!$db) 
        {
    echo 'Nie moge polaczyc sie z baza danych';
 	 }
	 
	  if ( !mysqli_select_db( $db,$nazwa_bazy_danych) ) 
        {
    echo 'Blad otwarcia bazy danych';
 	
        }
 
		$name = $_POST["name"];
		$surname = $_POST["surname"];
		$pesel = $_POST["pesel"];
		$email = $_POST["email"];
		$email_priv = $_POST["email2"];
		$data = $_POST["data"];
		$phone = $_POST["phone"];
		$plec = $_POST["plec"];
		$wspolnota = $_POST["wspolnota"];
	
		$street = $_POST["street"];
		$homeNumber = $_POST["homeNumber"];
		$flatNumber = $_POST["flatNumber"];
		$postcode = $_POST["postcode"];
		$post = $_POST["post"];
		$city = $_POST["city"];
	
		$contactName = $_POST["contactName"];
		$contactSurname = $_POST["contactSurname"];
		$contactPhone = $_POST["contactPhone"];
	
		$zdrowie = $_POST["zdrowie"];
		$dieta = $_POST["dieta"];
		$dietaInfo = $_POST["dietaInfo"];
	
		$obrona = $_POST["obrona"];
		$sesja = $_POST["sesja"];
		$koniecSesji = $_POST["koniecSesji"];
		$koszulka = $_POST["tshirt"];
		$chor = $_POST["chor"];
		$instrument = $_POST["instrument"];
		$posluga = $_POST["posluga"];
		$medycyna = $_POST["medycyna"];
		$uwagi = $_POST["uwagi"];
	
		$regulamin = $_POST["regulamin"];
		$szpital = $_POST["szpital"];
		$elektronika = $_POST["elektronika"];
		$rodo = $_POST["rodo"];
		$wizerunek = $_POST["wizerunek"];

		$zapytanie = "INSERT INTO 2024_studenci_Testowa (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc, imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek) 
		VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city', '$contactName', '$contactSurname', '$contactPhone', '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek' )";
	
	
		$zapytanie1 = "INSERT INTO 2024_studenci_Testowa_kopia (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc, imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek) 
		VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city', '$contactName', '$contactSurname', '$contactPhone', '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek' )";
  
  $wynik_zapytania = mysqli_query($db,$zapytanie);
  $wynik_zapytania1 = mysqli_query($db,$zapytanie1);
  
         if (!$wynik_zapytania || !$wynik_zapytania1) 
       {
         echo("<br />Nie moge dodaæ rekordu do bazy!!<br /><br />");
       } 

mysqli_close ($db);


// email stuff (change data below)

$imie=iconv('iso-8859-2','utf-8//TRANSLIT', $name);
$nazwisko=iconv('iso-8859-2','utf-8//TRANSLIT', $surname);

   $to = $_POST['email'];



$from = "obozy@dzielo.org.pl"; 

 $napis="- zg³oszenie studenta";
 $napis=iconv('iso-8859-2','utf-8//TRANSLIT', $napis);
 //$napis2="karta_obozowa.pdf";
   $subject = $name." ".
            	$surname." ".
              $napis." "."";

  // $karta = $imie."_".
     //       	$nazwisko."_".
       //       $napis2;

//$subject1 = iconv("windows-1250", "utf-8",$subject1);

$subject1= "=?utf-8?B?".base64_encode("$subject")."?=";

//$message = "<p>Stypendysto, Twoje zg³oszenie na obóz dla studentów zosta³o przyjête. 
//Na wskazany w formularzu adres email bêdziesz otrzymywa³ kolejne informacje o obozie. </p>";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
//$filename = "=?UTF-8?B?".base64_encode("$karta")."?=";

// encode data (puts attachment in proper format)
//$pdfdoc = $pdf->Output("", "S");

//$attachment = chunk_split(base64_encode($pdfdoc));



// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "Stypendysto, Twoje zg³oszenie na obóz dla studentów zosta³o przyjête. Na wskazany w formularzu adres email bêdziesz otrzymywa³ kolejne informacje o obozie.".$eol;
 $body=iconv('iso-8859-2','utf-8//TRANSLIT', $body);
// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-2\"".$eol;
//$body .= "Content-Type: text/html; charset=\"windows-1250\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// subject

// attachment
//$body .= "--".$separator.$eol;
//$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
//$body .= "Content-Transfer-Encoding: base64".$eol;
//$body .= "Content-Disposition: attachment".$eol.$eol;
//$body .= $attachment.$eol;
//$body .= "--".$separator."--";


// send message

   if($wynik_zapytania)
   {
     mail($to, $subject1, $body, $headers);
     mail("obozy.studenci@dzielo.pl", $subject1, $body, $headers);

	 session_destroy();
     header('Location: https://obozy.dzielo.pl/nowy_studenci/studenci/sukces.html');
   }
   else
   {
//session_destroy();
//header('Location: https://obozy.dzielo.pl/studenci/blad.html');
   }
}
}
}


?>