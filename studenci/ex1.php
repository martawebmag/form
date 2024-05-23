<?php
session_start();

require_once "../connect.php";


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



$pdo = new PDO('mysql:host=localhost;dbname=fundacja', 'root', '');


//Pobieranie danych
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


// Zapytanie SQL w celu znalezienia identyfikatora u�ytkownika na podstawie PESELu
$sql = "SELECT Id FROM 2024_studenci_1_dane_osobowe WHERE pesel = :pesel";
$stmt = $pdo->prepare($sql);
$stmt->execute([':pesel' => $pesel]);
$result = $stmt->fetch();

if ($result) {
    // Je�li u�ytkownik o danym PESELu zosta� znaleziony, pobierz jego identyfikator
    $userId = $result['Id'];

    // Wstawienie nowego zg�oszenia do tabeli "zgloszenia" z u�yciem identyfikatora u�ytkownika
    $sql = "INSERT INTO 2024_studenci_4_info_obozowe (dane_id, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) VALUES ('$userId',  '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':userId' => $userId]);

    // Zg�oszenie zosta�o dodane
} else {
    // Je�li u�ytkownik o danym PESELu nie zosta� znaleziony, dodaj nowego stypendyst�
    // echo "U�ytkownik o podanym PESELu nie istnieje.";

    $zapytanie1 = "INSERT INTO 2024_studenci_1_dane_osobowe (imie, nazwisko, pesel, data_urodzenia, email, email_prywatny, numer_telefonu, plec, wspolnota, data_zgloszenia) 
    VALUES ('$name', '$surname', '$pesel', '$data', '$email', '$email_priv', '$phone', '$plec', '$wspolnota', '$data_zgloszenia')";

    $zapytanie2 = "INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc) 
    VALUES ('$street', '$homeNumber', '$flatNumber', '$postcode', '$post', '$city')";

    $zapytanie3 = "INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy) 
    VALUES ('$contactName', '$contactSurname', '$contactPhone')";

    $zapytanie4 = "INSERT INTO 2024_studenci_4_info_obozowe (zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia) 
    VALUES ( '$zdrowie', '$dieta', '$dietaInfo', '$obrona', '$sesja', '$koniecSesji', '$koszulka', '$chor', '$instrument', '$posluga', '$medycyna', '$uwagi', '$regulamin', '$szpital', '$elektronika', '$rodo', '$wizerunek', '$data_zgloszenia' )";

$wynik_zapytania = ($zapytanie1 && $zapytanie2 && $zapytanie3 && $zapytanie4);

$result = $pdo->query($wynik_zapytania);

// $wynik_zapytania1z4 = mysqli_query($db,$zapytanie1);
// $wynik_zapytania2z4 = mysqli_query($db,$zapytanie2);
// $wynik_zapytania3z4 = mysqli_query($db,$zapytanie3);
// $wynik_zapytania4z4 = mysqli_query($db,$zapytanie4);


//      if (!$wynik_zapytania1z4 || !$wynik_zapytania2z4 || !$wynik_zapytania3z4 || !$wynik_zapytania4z4) 
//    {
//      echo("<br />Nie moge doda� rekordu do bazy!!<br /><br />");
//    } 


}





// Po��cz si� z baz� danych
// $pdo = new PDO('mysql:host=localhost;dbname=fundacja', 'root', '');

// // Ustaw atrybut PDO na wyrzucanie wyj�tk�w w przypadku b��d�w
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// // Sprawd�, czy formularz zosta� przes�any
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Pobierz dane z formularza
//     $pesel = $_POST['pesel'];
//     $dieta = $_POST['dieta'];
//     $koszulka = $_POST['koszulka'];
//     $uwagi = $_POST['uwagi'];
//     $zgody = $_POST['zgody'];

//     try {
//         // Rozpocznij transakcj�
//         $pdo->beginTransaction();

//         // Sprawd�, czy u�ytkownik o podanym PESELu istnieje w tabeli "uzytkownicy"
//         $stmt = $pdo->prepare("SELECT Id FROM uzytkownicy WHERE pesel = :pesel");
//         $stmt->execute([':pesel' => $pesel]);
//         $user = $stmt->fetch();

//         if ($user) {
//             // U�ytkownik o podanym PESELu istnieje, dodaj nowy zapis do tabeli "zapisy"
//             $userId = $user['Id'];

//             $stmt = $pdo->prepare("INSERT INTO zapisy (dane_id, dieta, koszulka, uwagi, zgody) VALUES (:userId, :dieta, :koszulka, :uwagi, :zgody)");
//             $stmt->execute([
//                 ':userId' => $userId,
//                 ':dieta' => $dieta,
//                 ':koszulka' => $koszulka,
//                 ':uwagi' => $uwagi,
//                 ':zgody' => $zgody
//             ]);

//             // Zako�cz transakcj�
//             $pdo->commit();

//             echo "Zapisano pomy�lnie!";
//         } else {
//             echo "U�ytkownik o podanym PESELu nie istnieje.";
//         }
//     } catch(PDOException $e) {
//         // Wycofaj transakcj� w przypadku b��du
//         $pdo->rollback();
//         echo "B��d: " . $e->getMessage();
//     }
// }

// // Zamknij po��czenie z baz� danych
// $pdo = null;










//wysy�ka emaila

// $to = $_POST['email'];
	
// $from = 'obozy@dzielo.org.pl';

// $replyTo = 'obozy@dzielo.org.pl';

// $napis="- zg�szenie studenta";
// $name=iconv('iso-8859-2','utf-8//TRANSLIT', $name);
// $surname=iconv('iso-8859-2','utf-8//TRANSLIT', $surname);
// $napis=iconv('iso-8859-2','utf-8//TRANSLIT', $napis);

// $subject = $name." ". $surname." ". $napis." "."";
// $subject= "=?utf-8?B?".base64_encode("$subject")."?=";

// $message1 =  '
// <html>
// <head>
//   <title>Zg�oszenie studenta</title>
// </head>
// <body>
//   <p>Szcz�� Bo�e!</p>
//   <p>Stypendysto, Twoje zg�oszenie na ob�z dla student�w zosta�o przyj�te. Na wskazany w formularzu adres email b�dziesz otrzymywa� kolejne informacje o obozie. </p>
//   <p>Je�li oka�e si�, �e pomimo wys�anego zg�oszenia, z wa�nych powod�w, nie mo�esz przyjecha� na ob�z lub musisz skr�ci� sw�j pobyt, poinformuj nas o tym wysy�aj�c e-mail na adres: obozy@dzielo.pl  Nast�pnie post�puj zgodnie z instrukcj�, kt�r� dostaniesz w odpowiedzi na swoj� wiadomo��.</p>
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



// // send message

//    if($sql)
//    {
// 	mail($to, $subject, $message1, $headers);
//     // mail("obozy.studenci@dzielo.pl", $subject, $message1, $headers);

// 	 session_destroy();
//      header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
//    }
//    else
//    {
// //session_destroy();
// //header('Location: https://obozy.dzielo.pl/studenci/blad.html');
//    }
}
}
}


