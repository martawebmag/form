<?php
// Ustawienia po³±czenia z baz± danych
$dsn = 'mysql:host=localhost;dbname=fundacja;charset=utf8';
$username = 'root';
$password = '';

try {
    // Utwórz po³±czenie z baz± danych za pomoc± PDO
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Identyfikator u¿ytkownika, którego dane chcemy wyci±gn±æ
    $userId = 5; // Zamieñ na odpowiednie ID u¿ytkownika

    // Zapytanie SQL do wyci±gniêcia danych z tabeli dane_osobowe, adres, kontakt
    $sql = "
        SELECT 
            do.imie, do.nazwisko, do.pesel, do.data_urodzenia, do.email, do.email_prywatny, do.numer_telefonu, do.plec, do.wspolnota, do.data_zgloszenia,
            a.ulica, a.numer_domu, a.numer_mieszkania, a.kod_pocztowy, a.poczta, a.miejscowosc,
            k.imie_kontaktu, k.nazwisko_kontaktu, k.telefon_kontaktowy,
            io.zdrowie, io.dieta, io.dieta_szczegoly, io.obrona, io.sesja, io.koniec_sesji, io.koszulka_rozmiar, io.chor, io.instrument, io.posluga, io.medycyna, io.uwagi, io.zgoda_regulamin, io.zgoda_szpital, io.zgoda_elektronika, io.zgoda_rodo, io.zgoda_wizerunek, io.data_zgloszenia_info
        FROM 
            2024_studenci_1_dane_osobowe do
        LEFT JOIN 
            2024_studenci_2_adres a ON do.id = a.dane_id
        LEFT JOIN 
            2024_studenci_3_kontakt k ON do.id = k.dane_id
        LEFT JOIN 
            (
                SELECT * FROM 2024_studenci_4_info_obozowe 
                WHERE data_zgloszenia_info > '2024-01-01'
                AND dane_id = :userId
                ORDER BY data_zgloszenia_info DESC
                LIMIT 1
            ) io ON do.id = io.dane_id
        WHERE 
            do.id = :userId
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Pobierz dane
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Nag³ówki CSV
        $headers = array_keys($data);

        // Tworzenie pliku CSV
        $filename = "user_data.csv";
        $file = fopen($filename, 'w');

        // Zapis nag³ówków
        fputcsv($file, $headers);

        // Zapis danych u¿ytkownika
        fputcsv($file, $data);

        fclose($file);

        echo "Dane zosta³y zapisane do pliku $filename";
    } else {
        echo "Nie znaleziono danych dla podanego ID u¿ytkownika.";
    }

} catch (PDOException $e) {
    echo "B³±d PDO: " . $e->getMessage();
} catch (Exception $e) {
    echo "B³±d: " . $e->getMessage();
}
?>
