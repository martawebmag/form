<?php
session_start();	


require_once "../connect.php";


// Po³±cz siê z baz± danych
$conn=mysqli_connect($host, $db_user, $db_password, $db_name);

// Sprawd¼ po³±czenie
if (!$conn) {
    die("B³±d po³±czenia z baz± danych: " . mysqli_connect_error());
}

// Przetwórz dane formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dane z formularza
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

    // Uzyskaj identyfikator u¿ytkownika na podstawie numeru PESEL
    $result = mysqli_query($conn, "SELECT id FROM 2024_studenci_1_dane_osobowe WHERE pesel = '$pesel'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dane_id = $row['id'];

        // Dodaj zg³oszenie do tabeli "info_obozowe"
        $sql = "INSERT INTO 2024_studenci_4_info_obozowe (dane_id, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) 
		VALUES ('$dane_id', '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia' )";

        if (mysqli_query($conn, $sql)) {
			header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
        } else {
            echo "B³±d: " . mysqli_error($conn);
        }
    } else {
		//nie ma jescze u¿ytownika o podanym peselu - dodajemy nowego
        $zapytanie1 = "INSERT INTO 2024_studenci_1_dane_osobowe (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, data_zgloszenia) 
		VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$data_zgloszenia')";


		$zapytanie2 = "INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc) 
		VALUES ('$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city')";


		$zapytanie3 = "INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy) 
		VALUES ('$contactName', '$contactSurname', '$contactPhone')";


		$zapytanie4 = "INSERT INTO 2024_studenci_4_info_obozowe (zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) 
		VALUES ( '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia' )";
  



			$wynik_zapytania1z4 = mysqli_query($conn,$zapytanie1);
			$wynik_zapytania2z4 = mysqli_query($conn,$zapytanie2);
			$wynik_zapytania3z4 = mysqli_query($conn,$zapytanie3);
			$wynik_zapytania4z4 = mysqli_query($conn,$zapytanie4);

			header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
    }

    // Zamknij po³±czenie z baz± danych
    mysqli_close($conn);
}







 
//  $db=mysqli_connect($host, $db_user, $db_password, $db_name);



     
//     if (!$db) 
//         {
//     echo 'Nie moge polaczyc sie z baza danych';
//  	 }
	 
// 	  if ( !mysqli_select_db( $db, $db_name) ) 
//         {
//     echo 'Blad otwarcia bazy danych';
 	
//         }
 
// 		$name = $_POST["name"];
// 		$surname = $_POST["surname"];
// 		$pesel = $_POST["pesel"];
// 		$email = $_POST["email"];
// 		$email_priv = $_POST["email2"];
// 		$data = $_POST["data"];
// 		$phone = $_POST["phone"];
// 		$plec = $_POST["plec"];
// 		$wspolnota = $_POST["wspolnota"];
	
// 		$street = $_POST["street"];
// 		$homeNumber = $_POST["homeNumber"];
// 		$flatNumber = $_POST["flatNumber"];
// 		$postcode = $_POST["postcode"];
// 		$post = $_POST["post"];
// 		$city = $_POST["city"];
	
// 		$contactName = $_POST["contactName"];
// 		$contactSurname = $_POST["contactSurname"];
// 		$contactPhone = $_POST["contactPhone"];
	
// 		$zdrowie = $_POST["zdrowie"];
// 		$dieta = $_POST["dieta"];
// 		$dietaInfo = $_POST["dietaInfo"];
	
// 		$obrona = $_POST["obrona"];
// 		$sesja = $_POST["sesja"];
// 		$koniecSesji = $_POST["koniecSesji"];
// 		$koszulka = $_POST["tshirt"];
// 		$chor = $_POST["chor"];
// 		$instrument = $_POST["instrument"];
// 		$posluga = $_POST["posluga"];
// 		$medycyna = $_POST["medycyna"];
// 		$uwagi = $_POST["uwagi"];
	
// 		$regulamin = $_POST["regulamin"];
// 		$szpital = $_POST["szpital"];
// 		$elektronika = $_POST["elektronika"];
// 		$rodo = $_POST["rodo"];
// 		$wizerunek = $_POST["wizerunek"];

// 		$data_zgloszenia = date("Y-m-d H:i:s");

// 		$zapytanie1 = "INSERT INTO 2024_studenci_1_dane_osobowe (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, data_zgloszenia) 
// 		VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$data_zgloszenia')";


// 		$zapytanie2 = "INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc) 
// 		VALUES ('$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city')";


// 		$zapytanie3 = "INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy) 
// 		VALUES ('$contactName', '$contactSurname', '$contactPhone')";


// 		$zapytanie4 = "INSERT INTO 2024_studenci_4_info_obozowe (zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) 
// 		VALUES ( '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia' )";
  



//   $wynik_zapytania1z4 = mysqli_query($db,$zapytanie1);
//   $wynik_zapytania2z4 = mysqli_query($db,$zapytanie2);
//   $wynik_zapytania3z4 = mysqli_query($db,$zapytanie3);
//   $wynik_zapytania4z4 = mysqli_query($db,$zapytanie4);

  
//          if (!$wynik_zapytania1z4 || !$wynik_zapytania2z4 || !$wynik_zapytania3z4 || !$wynik_zapytania4z4) 
//        {
//          echo("<br />Nie moge dodaæ rekordu do bazy!!<br /><br />");
//        } else {

// 		header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
// 	   }

// mysqli_close ($conn);


//przykï¿½ad

// $to = $_POST['email'];
	
// $from = 'obozy@dzielo.org.pl';

// $replyTo = 'obozy@dzielo.org.pl';

// $napis="- zgï¿½oszenie studenta";
// $name=iconv('iso-8859-2','utf-8//TRANSLIT', $name);
// $surname=iconv('iso-8859-2','utf-8//TRANSLIT', $surname);
// $napis=iconv('iso-8859-2','utf-8//TRANSLIT', $napis);

// $subject = $name." ". $surname." ". $napis." "."";
// $subject= "=?utf-8?B?".base64_encode("$subject")."?=";

// $message1 =  '
// <html>
// <head>
//   <title>Zgï¿½oszenie studenta</title>
// </head>
// <body>
//   <p>Szczï¿½ï¿½ Boï¿½e!</p>
//   <p>Stypendysto, Twoje zgï¿½oszenie na obï¿½z dla studentï¿½w zostaï¿½o przyjï¿½te. Na wskazany w formularzu adres email bï¿½dziesz otrzymywaï¿½ kolejne informacje o obozie. </p>
//   <p>Jeï¿½li okaï¿½e siï¿½, ï¿½e pomimo wysï¿½anego zgï¿½oszenia, z waï¿½nych powodï¿½w, nie moï¿½esz przyjechaï¿½ na obï¿½z lub musisz skrï¿½ciï¿½ swï¿½j pobyt, poinformuj nas o tym wysyï¿½ajï¿½c e-mail na adres: obozy@dzielo.pl  Nastï¿½pnie postï¿½puj zgodnie z instrukcjï¿½, ktï¿½rï¿½ dostaniesz w odpowiedzi na swojï¿½ wiadomoï¿½ï¿½.</p>
//   <br>
//   <p>Pozdrawiamy,</p>
//   <p>Biuro obozu</p>
//   <p>668286096</p>
// </body>
// </html>';

// $message1=iconv('iso-8859-2','utf-8//TRANSLIT', $message1);



// $headers  = 'MIME-Version: 1.0'."\r\n";
// $headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";
// $headers .= 'From: '.$from."\r\n";
// $headers .= 'Reply-To: '.$replyTo."\r\n";



// send message

//    if($wynik_zapytania1z4 || $wynik_zapytania2z4 || $wynik_zapytania3z4 || $wynik_zapytania4z4)
//    {
// 	mail($to, $subject, $message1, $headers);
//     // mail("obozy.studenci@dzielo.pl", $subject, $message1, $headers);

// 	 session_destroy();
//      header('Location: http://localhost/formularz_studenci_nowy');
//    }
//    else
//    {
// //session_destroy();
// //header('Location: https://obozy.dzielo.pl/studenci/blad.html');
//    }


// if(!preg_match('/^[a-zA-Z0-9.\-_]+\@dzielo.pl$/D', $_POST['email']))
// {
// session_destroy();
// header('Location: https://obozy.dzielo.pl/studenci/blad.html');
// }
// else
// {

// if(!preg_match('/^[0-9]{11}$/', $_POST['pesel']))
// {
// session_destroy();
// header('Location: https://obozy.dzielo.pl/studenci/blad.html');
// }
// else
// {

// if (!preg_match('/^[a-z0-9]{9,16}$/', $_POST['phone'])) 
// {
// session_destroy();
// header('Location: https://obozy.dzielo.pl/studenci/blad.html');
// }
// else
// {



// 	if ($_POST['name']=="" || $_POST['surname']=="" ||
// 	$_POST['pesel']=="" || $_POST['data']=="" ||
// 	$_POST['email']=="" || $_POST['email2']=="" || $_POST['phone']=="" || 
// 	$_POST['post']=="" || $_POST['postcode']=="" ||
// 	$_POST['city']=="" || $_POST["wspolnota"] == "-" ||
// 	$_POST['dieta']=="-" || $_POST['homeNumber']=="" ||
// 	$_POST['regulamin']=="" || $_POST['szpital']=="" ||
// 	$_POST['plec']=="-" || $_POST['elektronika']==""|| 
// 	$_POST['wizerunek']=="" || $_POST['tshirt']=="-" || $_POST['rodo']=="" ) {

// session_destroy();
// header('Location: https://obozy.dzielo.pl/testowy/blad.html');
// }
// }
// }}


