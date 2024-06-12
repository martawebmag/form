<?php
session_start();

$dsn = 'mysql:host=localhost;dbname=fundacja;charset=utf8';
$username = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pobierz dane_id z sesji
    if (isset($_SESSION['dane_id']) && isset($_SESSION['form_data'])) {
        $dane_id = $_SESSION['dane_id'];
        $form_data = $_SESSION['form_data'];
    } else {
        echo "B³±d: Brak danych w sesji.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['update'] == 'yes') {
            // Aktualizuj zg³oszenie w tabeli "2024_studenci_4_info_obozowe"
            $stmt = $conn->prepare("UPDATE 2024_studenci_4_info_obozowe SET zdrowie = :zdrowie, dieta = :dieta, jaka_dieta = :jakaDieta, dieta_szczegoly = :dieta_szczegoly, obrona = :obrona, sesja = :sesja, koniec_sesji = :koniecSesji, koszulka_rozmiar = :koszulka_rozmiar, chor = :chor, instrument = :instrument, posluga = :posluga, medycyna = :medycyna, uwagi = :uwagi, zgoda_regulamin = :zgoda_regulamin, zgoda_szpital = :zgoda_szpital, zgoda_elektronika = :zgoda_elektronika, zgoda_rodo = :zgoda_rodo, zgoda_wizerunek = :zgoda_wizerunek, data_zgloszenia_info = NOW() WHERE dane_id = :dane_id AND YEAR(data_zgloszenia_info) = YEAR(NOW())");
            $stmt->bindParam(':dane_id', $dane_id);
            $stmt->bindParam(':zdrowie', $form_data['zdrowie']);
            $stmt->bindParam(':dieta', $form_data['dieta']);
            $stmt->bindParam(':jakaDieta', $form_data['jakaDieta']);
            $stmt->bindParam(':dieta_szczegoly', $form_data['dietaInfo']);
            $stmt->bindParam(':obrona', $form_data['obrona']);
            $stmt->bindParam(':sesja', $form_data['sesja']);
            $stmt->bindParam(':koniecSesji', $form_data['koniecSesji']);
            $stmt->bindParam(':koszulka_rozmiar', $form_data['tshirt']);
            $stmt->bindParam(':chor', $form_data['chor']);
            $stmt->bindParam(':instrument', $form_data['instrument']);
            $stmt->bindParam(':posluga', $form_data['posluga']);
            $stmt->bindParam(':medycyna', $form_data['medycyna']);
            $stmt->bindParam(':uwagi', $form_data['uwagi']);
            $stmt->bindParam(':zgoda_regulamin', $form_data['regulamin']);
            $stmt->bindParam(':zgoda_szpital', $form_data['szpital']);
            $stmt->bindParam(':zgoda_elektronika', $form_data['elektronika']);
            $stmt->bindParam(':zgoda_rodo', $form_data['rodo']);
            $stmt->bindParam(':zgoda_wizerunek', $form_data['wizerunek']);
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE 2024_studenci_1_dane_osobowe SET nazwisko=:nazwisko, email_prywatny=:email_prywatny, numer_telefonu=:numer_telefonu WHERE id=:id");
            $stmt->bindParam(':nazwisko', $form_data['surname']);
            $stmt->bindParam(':email_prywatny', $form_data['email2']);
            $stmt->bindParam(':numer_telefonu', $form_data['phone']);
            $stmt->bindParam(':id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas aktualizacji danych u¿ytkownika.");
            }

            $stmt = $conn->prepare("UPDATE 2024_studenci_2_adres SET ulica=:ulica, numer_domu=:numer_domu, numer_mieszkania=:numer_mieszkania, kod_pocztowy=:kod_pocztowy, poczta=:poczta, miejscowosc=:miejscowosc WHERE dane_id=:dane_id");
            $stmt->bindParam(':ulica', $form_data['street']);
            $stmt->bindParam(':numer_domu', $form_data['homeNumber']);
            $stmt->bindParam(':numer_mieszkania', $form_data['flatNumber']);
            $stmt->bindParam(':kod_pocztowy', $form_data['postcode']);
            $stmt->bindParam(':poczta', $form_data['post']);
            $stmt->bindParam(':miejscowosc', $form_data['city']);
            $stmt->bindParam(':dane_id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas aktualizacji danych adresowych u¿ytkownika.");
            }

            $stmt = $conn->prepare("UPDATE 2024_studenci_3_kontakt SET imie_kontaktu=:imie_kontaktu, nazwisko_kontaktu=:nazwisko_kontaktu, telefon_kontaktowy=:telefon_kontaktowy WHERE dane_id=:dane_id");
            $stmt->bindParam(':imie_kontaktu', $form_data['contactName']);
            $stmt->bindParam(':nazwisko_kontaktu', $form_data['contactSurname']);
            $stmt->bindParam(':telefon_kontaktowy', $form_data['contactPhone']);
            $stmt->bindParam(':dane_id', $dane_id);
            if (!$stmt->execute()) {
                throw new Exception("B³±d podczas aktualizacji danych kontaktowych u¿ytkownika.");
            }


            header('Location: http://localhost/formularz_studenci_nowy04/studenci/sukces.html');
        } else {
            header('Location: http://localhost/formularz_studenci_nowy04/studenci/sukces.html');
        }

        // Wyczyszczenie sesji
        unset($_SESSION['dane_id']);
        unset($_SESSION['form_data']);
    }
} catch (PDOException $e) {
    echo "B³±d PDO: " . $e->getMessage();
}

include_once ('update.html');


