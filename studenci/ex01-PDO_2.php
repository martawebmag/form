<?php
session_start();

$username = 'root';
$dsn = 'mysql:host=localhost;dbname=fundacja;charset=utf8';
$password = '';

try {
    // Utwórz po³±czenie z baz± danych za pomoc± PDO
    $conn = new PDO($dsn, $username, $password);
    // Ustaw tryb raportowania b³êdów
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Funkcja do walidacji danych wej¶ciowych
    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Przetwórz dane formularza
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Walidacja danych wej¶ciowych
        $name = test_input($_POST['name']);
        $surname = test_input($_POST['surname']);
        $pesel = test_input($_POST['pesel']);
        $email = test_input($_POST['email']);
        $email_priv = test_input($_POST['email2']);
        $data = test_input($_POST['data']);
        $phone = test_input($_POST['phone']);
        $plec = test_input($_POST['plec']);
        $wspolnota = test_input($_POST['wspolnota']);
        $street = test_input($_POST["street"]);
        $homeNumber = test_input($_POST["homeNumber"]);
        $flatNumber = test_input($_POST["flatNumber"]);
        $postcode = test_input($_POST["postcode"]);
        $post = test_input($_POST["post"]);
        $city = test_input($_POST["city"]);
        $contactName = test_input($_POST["contactName"]);
        $contactSurname = test_input($_POST["contactSurname"]);
        $contactPhone = test_input($_POST["contactPhone"]);
        $zdrowie = test_input($_POST["zdrowie"]);
        $dieta = test_input($_POST["dieta"]);
        $dietaInfo = test_input($_POST["dietaInfo"]);
        $obrona = test_input($_POST["obrona"]);
        $sesja = test_input($_POST["sesja"]);
        $koniecSesji = test_input($_POST["koniecSesji"]);
        $koszulka = test_input($_POST["tshirt"]);
        $chor = test_input($_POST["chor"]);
        $instrument = test_input($_POST["instrument"]);
        $posluga = test_input($_POST["posluga"]);
        $medycyna = test_input($_POST["medycyna"]);
        $uwagi = test_input($_POST["uwagi"]);
        $regulamin = test_input($_POST["regulamin"]);
        $szpital = test_input($_POST["szpital"]);
        $elektronika = test_input($_POST["elektronika"]);
        $rodo = test_input($_POST["rodo"]);
        $wizerunek = test_input($_POST["wizerunek"]);
        $data_zgloszenia = date("Y-m-d H:i:s");
        $data_zgloszenia_info = date("Y-m-d H:i:s");

        // Sprawd¼, czy u¿ytkownik o podanym numerze PESEL istnieje
        $stmt = $conn->prepare("SELECT id FROM 2024_studenci_1_dane_osobowe WHERE pesel = :pesel");
        $stmt->bindParam(':pesel', $pesel);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // U¿ytkownik istnieje, pobierz jego ID i zaktualizuj dane
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dane_id = $row['id'];

            // Zaktualizuj dane u¿ytkownika w tabeli "2024_studenci_1_dane_osobowe"
            $stmt = $conn->prepare("UPDATE 2024_studenci_1_dane_osobowe SET nazwisko=:nazwisko, email_prywatny=:email_prywatny, numer_telefonu=:numer_telefonu WHERE id=:id");
            $stmt->bindParam(':nazwisko', $surname);
            $stmt->bindParam(':email_prywatny', $email_priv);
            $stmt->bindParam(':numer_telefonu', $phone);
            $stmt->bindParam(':id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas aktualizacji danych u¿ytkownika.");
            }

            // Sprawd¼, czy s± dane adresowe
            $stmt = $conn->prepare("SELECT id FROM 2024_studenci_2_adres WHERE dane_id = :dane_id");
            $stmt->bindParam(':dane_id', $dane_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                // Dane adresowe istniej±, zaktualizuj je
                $stmt = $conn->prepare("UPDATE 2024_studenci_2_adres SET ulica=:ulica, numer_domu=:numer_domu, numer_mieszkania=:numer_mieszkania, kod_pocztowy=:kod_pocztowy, poczta=:poczta, miejscowosc=:miejscowosc WHERE dane_id=:dane_id");
                $stmt->bindParam(':ulica', $street);
                $stmt->bindParam(':numer_domu', $homeNumber);
                $stmt->bindParam(':numer_mieszkania', $flatNumber);
                $stmt->bindParam(':kod_pocztowy', $postcode);
                $stmt->bindParam(':poczta', $post);
                $stmt->bindParam(':miejscowosc', $city);
                $stmt->bindParam(':dane_id', $dane_id);
                if (!$stmt->execute()) {
                    throw new Exception("B³±d podczas aktualizacji danych adresowych u¿ytkownika.");
                }
            } else {
                // Brak danych adresowych, dodaj nowe dane
                $stmt = $conn->prepare("INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc, dane_id) VALUES (:ulica, :numer_domu, :numer_mieszkania, :kod_pocztowy, :poczta, :miejscowosc, :dane_id)");
                $stmt->bindParam(':ulica', $street);
                $stmt->bindParam(':numer_domu', $homeNumber);
                $stmt->bindParam(':numer_mieszkania', $flatNumber);
                $stmt->bindParam(':kod_pocztowy', $postcode);
                $stmt->bindParam(':poczta', $post);
                $stmt->bindParam(':miejscowosc', $city);
                $stmt->bindParam(':dane_id', $dane_id);
                if (!$stmt->execute()) {
                    throw new Exception("B³±d podczas dodawania danych adresowych.");
                }
            }

            // Analogicznie dla danych kontaktowych
            $stmt = $conn->prepare("SELECT id FROM 2024_studenci_3_kontakt WHERE dane_id = :dane_id");
            $stmt->bindParam(':dane_id', $dane_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                // Dane kontaktowe istniej±, zaktualizuj je
                $stmt = $conn->prepare("UPDATE 2024_studenci_3_kontakt SET imie_kontaktu=:imie_kontaktu, nazwisko_kontaktu=:nazwisko_kontaktu, telefon_kontaktowy=:telefon_kontaktowy WHERE dane_id=:dane_id");
                $stmt->bindParam(':imie_kontaktu', $contactName);
                $stmt->bindParam(':nazwisko_kontaktu', $contactSurname);
                $stmt->bindParam(':telefon_kontaktowy', $contactPhone);
                $stmt->bindParam(':dane_id', $dane_id);
                if (!$stmt->execute()) {
                    throw new Exception("B³±d podczas aktualizacji danych kontaktowych u¿ytkownika.");
                }
            } else {
                // Brak danych kontaktowych, dodaj nowe dane
                $stmt = $conn->prepare("INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy, dane_id) VALUES (:imie_kontaktu, :nazwisko_kontaktu, :telefon_kontaktowy, :dane_id)");
                $stmt->bindParam(':imie_kontaktu', $contactName);
                $stmt->bindParam(':nazwisko_kontaktu', $contactSurname);
                $stmt->bindParam(':telefon_kontaktowy', $contactPhone);
                $stmt->bindParam(':dane_id', $dane_id);
                if (!$stmt->execute()) {
                    throw new Exception("B³±d podczas dodawania danych kontaktowych.");
                }
            }

        } else {
            // U¿ytkownik nie istnieje, dodaj nowego u¿ytkownika
            $stmt = $conn->prepare("INSERT INTO 2024_studenci_1_dane_osobowe (imie, nazwisko, pesel, email_prywatny, email, numer_telefonu, data_urodzenia, plec, wspolnota, data_zgloszenia) VALUES (:imie, :nazwisko, :pesel, :email_prywatny, :email, :numer_telefonu, :data_urodzenia, :plec, :wspolnota, :data_zgloszenia)");
            $stmt->bindParam(':imie', $name);
            $stmt->bindParam(':nazwisko', $surname);
            $stmt->bindParam(':pesel', $pesel);
            $stmt->bindParam(':email_prywatny', $email_priv);
			$stmt->bindParam(':email', $email);
            $stmt->bindParam(':numer_telefonu', $phone);
            $stmt->bindParam(':data_urodzenia', $data);
            $stmt->bindParam(':plec', $plec);
            $stmt->bindParam(':wspolnota', $wspolnota);
			$stmt->bindParam(':data_zgloszenia', $data_zgloszenia);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas dodawania nowego u¿ytkownika.");
            }
            $dane_id = $conn->lastInsertId();

            // Dodaj dane adresowe
            $stmt = $conn->prepare("INSERT INTO 2024_studenci_2_adres (ulica, numer_domu, numer_mieszkania, kod_pocztowy, poczta, miejscowosc, dane_id) VALUES (:ulica, :numer_domu, :numer_mieszkania, :kod_pocztowy, :poczta, :miejscowosc, :dane_id)");
            $stmt->bindParam(':ulica', $street);
            $stmt->bindParam(':numer_domu', $homeNumber);
            $stmt->bindParam(':numer_mieszkania', $flatNumber);
            $stmt->bindParam(':kod_pocztowy', $postcode);
            $stmt->bindParam(':poczta', $post);
            $stmt->bindParam(':miejscowosc', $city);
            $stmt->bindParam(':dane_id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas dodawania danych adresowych.");
            }

            // Dodaj dane kontaktowe
            $stmt = $conn->prepare("INSERT INTO 2024_studenci_3_kontakt (imie_kontaktu, nazwisko_kontaktu, telefon_kontaktowy, dane_id) VALUES (:imie_kontaktu, :nazwisko_kontaktu, :telefon_kontaktowy, :dane_id)");
            $stmt->bindParam(':imie_kontaktu', $contactName);
            $stmt->bindParam(':nazwisko_kontaktu', $contactSurname);
            $stmt->bindParam(':telefon_kontaktowy', $contactPhone);
            $stmt->bindParam(':dane_id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas dodawania danych kontaktowych.");
            }
        }


        // Dodaj nowe zg³oszenie do tabeli "2024_studenci_4_info_obozowe"
		$stmt = $conn->prepare("INSERT INTO 2024_studenci_4_info_obozowe (dane_id, zdrowie, dieta, dieta_szczegoly, obrona, sesja, koniec_sesji, koszulka_rozmiar, chor, instrument, posluga, medycyna, uwagi, zgoda_regulamin, zgoda_szpital, zgoda_elektronika, zgoda_rodo, zgoda_wizerunek, data_zgloszenia_info) VALUES (:dane_id, :zdrowie, :dieta, :dieta_szczegoly, :obrona, :sesja, :koniec_sesji, :koszulka_rozmiar, :chor, :instrument, :posluga, :medycyna, :uwagi, :zgoda_regulamin, :zgoda_szpital, :zgoda_elektronika, :zgoda_rodo, :zgoda_wizerunek, :data_zgloszenia_info)");
        $stmt->bindParam(':dane_id', $dane_id);
        $stmt->bindParam(':zdrowie', $zdrowie);
        $stmt->bindParam(':dieta', $dieta);
        $stmt->bindParam(':dieta_szczegoly', $dietaInfo);
        $stmt->bindParam(':obrona', $obrona);
        $stmt->bindParam(':sesja', $sesja);
        $stmt->bindParam(':koniec_sesji', $koniecSesji);
        $stmt->bindParam(':koszulka_rozmiar', $koszulka);
        $stmt->bindParam(':chor', $chor);
        $stmt->bindParam(':instrument', $instrument);
        $stmt->bindParam(':posluga', $posluga);
        $stmt->bindParam(':medycyna', $medycyna);
        $stmt->bindParam(':uwagi', $uwagi);
        $stmt->bindParam(':zgoda_regulamin', $regulamin);
        $stmt->bindParam(':zgoda_szpital', $szpital);
        $stmt->bindParam(':zgoda_elektronika', $elektronika);
        $stmt->bindParam(':zgoda_rodo', $rodo);
        $stmt->bindParam(':zgoda_wizerunek', $wizerunek);
        $stmt->bindParam(':data_zgloszenia_info', $data_zgloszenia);
        if (!$stmt->execute()) {
            throw new Exception("B³±d podczas dodawania zg³oszenia.");
        }

		header('Location: http://localhost/formularz_studenci_nowy02/studenci/sukces.html');
    }
} catch (PDOException $e) {
    echo "B³±d PDO: " . $e->getMessage();
} catch (Exception $e) {
    echo "B³±d: " . $e->getMessage();
}

// Zamknij po³±czenie z baz± danych
$conn = null;
?>
