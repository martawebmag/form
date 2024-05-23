<?php
session_start();	

if(!preg_match('/^[a-zA-Z0-9.\-_]+\@dzielo.pl$/D', $_POST['email']))
{
session_destroy();
header('Location: https://obozy.dzielo.pl/studenci/blad.html');
}
else
{

if(!preg_match('/^[0-9]{11}$/', $_POST['pesel']))
{
session_destroy();
header('Location: https://obozy.dzielo.pl/studenci/blad.html');
}
else
{

if (!preg_match('/^[a-z0-9]{9,16}$/', $_POST['phone'])) 
{
session_destroy();
header('Location: https://obozy.dzielo.pl/studenci/blad.html');
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
header('Location: https://obozy.dzielo.pl/testowy/blad.html');
}

require_once "../connect.php";

 
 $db = mysqli_connect($host, $db_user, $db_password, $db_name);

     
    if (!$db) 
        {
    echo 'Nie moge polaczyc sie z baza danych';
 	 }
	 
	  if ( !mysqli_select_db( $db, $db_name) ) 
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

		$data_zgloszenia = date("Y-m-d H:i:s");


		// $zapytanie = "INSERT INTO 2024_studenci_gniezno_kopia (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc, imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek) 
		// VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city', '$contactName', '$contactSurname', '$contactPhone', '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek' )";


		$zapytanie1 = "INSERT INTO 2024_studenci_1_dane_osobowe (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, data_zgloszenia) 
		VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$data_zgloszenia')";


		$zapytanie2 = "INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc) 
		VALUES ('$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city')";


		$zapytanie3 = "INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy) 
		VALUES ('$contactName', '$contactSurname', '$contactPhone')";


		$zapytanie4 = "INSERT INTO 2024_studenci_4_info_obozowe (zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) 
		VALUES ( '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia' )";
  






// Po��czenie z baz� danych
// $pdo = new PDO('mysql:host=host;dbname=nazwa_bazy', 'uzytkownik', 'haslo');

// // Zapytanie SQL w celu znalezienia identyfikatora u�ytkownika na podstawie PESELu
// $sql = "SELECT id FROM uzytkownicy WHERE pesel = :pesel";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([':pesel' => $pesel]);
// $result = $stmt->fetch();

// if ($result) {
//     // Je�li u�ytkownik o danym PESELu zosta� znaleziony, pobierz jego identyfikator
//     $userId = $result['id'];

//     // Wstawienie nowego zg�oszenia do tabeli "zgloszenia" z u�yciem identyfikatora u�ytkownika
//     $sql = "INSERT INTO zgloszenia (dane_id, inna_kolumna, kolejna_kolumna) VALUES (:userId, 'wartosc', 'inne')";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([':userId' => $userId]);

//     // Zg�oszenie zosta�o dodane
// } else {
//     // Je�li u�ytkownik o danym PESELu nie zosta� znaleziony, obs�u� ten przypadek
//     echo "U�ytkownik o podanym PESELu nie istnieje.";
// }











  $wynik_zapytania1z4 = mysqli_query($db,$zapytanie1);
  $wynik_zapytania2z4 = mysqli_query($db,$zapytanie2);
  $wynik_zapytania3z4 = mysqli_query($db,$zapytanie3);
  $wynik_zapytania4z4 = mysqli_query($db,$zapytanie4);

  
         if (!$wynik_zapytania1z4 || !$wynik_zapytania2z4 || !$wynik_zapytania3z4 || !$wynik_zapytania4z4) 
       {
         echo("<br />Nie moge doda� rekordu do bazy!!<br /><br />");
       } 

mysqli_close ($db);


//przyk�ad

$to = $_POST['email'];
	
$from = 'obozy@dzielo.org.pl';

$replyTo = 'obozy@dzielo.org.pl';

$napis="- zg�szenie studenta";
$name=iconv('iso-8859-2','utf-8//TRANSLIT', $name);
$surname=iconv('iso-8859-2','utf-8//TRANSLIT', $surname);
$napis=iconv('iso-8859-2','utf-8//TRANSLIT', $napis);

$subject = $name." ". $surname." ". $napis." "."";
$subject= "=?utf-8?B?".base64_encode("$subject")."?=";

$message1 =  '
<html>
<head>
  <title>Zg�oszenie studenta</title>
</head>
<body>
  <p>Szcz�� Bo�e!</p>
  <p>Stypendysto, Twoje zg�oszenie na ob�z dla student�w zosta�o przyj�te. Na wskazany w formularzu adres email b�dziesz otrzymywa� kolejne informacje o obozie. </p>
  <p>Je�li oka�e si�, �e pomimo wys�anego zg�oszenia, z wa�nych powod�w, nie mo�esz przyjecha� na ob�z lub musisz skr�ci� sw�j pobyt, poinformuj nas o tym wysy�aj�c e-mail na adres: obozy@dzielo.pl  Nast�pnie post�puj zgodnie z instrukcj�, kt�r� dostaniesz w odpowiedzi na swoj� wiadomo��.</p>
  <br>
  <p>Pozdrawiamy,</p>
  <p>Biuro obozu</p>
  <p>668286096</p>
</body>
</html>';

$message1=iconv('iso-8859-2','utf-8//TRANSLIT', $message1);



$headers  = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";
$headers .= 'From: '.$from."\r\n";
$headers .= 'Reply-To: '.$replyTo."\r\n";



// send message

   if(!$wynik_zapytania1z4 || !$wynik_zapytania2z4 || !$wynik_zapytania3z4 || !$wynik_zapytania4z4)
   {
	mail($to, $subject, $message1, $headers);
    // mail("obozy.studenci@dzielo.pl", $subject, $message1, $headers);

	 session_destroy();
     header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
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