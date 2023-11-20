<?php
// Verbindung zur Datenbank herstellen
$conn = new mysqli("localhost", "root", "", "kundenverwaltung");

// Prüfen, ob die Verbindung fehlgeschlagen ist
if ($conn->connect_error) {
    // Bei Fehlschlagen der Verbindung: Fehlermeldung ausgeben und das Skript beenden
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Manage Customer: Anlegen/Bearbeiten von Kunden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Kundenname und Anrede aus dem Formular holen
    $anrede = $_POST['anrede'];
    $kundenname = $_POST['kundenname'];
    $email = $_POST['email'];

    // E-Mail-Adresse validieren
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Die E-Mail-Adresse ist ungültig.";
        return;
    }

    // SQL-Abfrage für das Suchen eines Kunden mit dem angegebenen Kundennamen und Anrede erstellen
    $sql = "SELECT * FROM Kunde WHERE name = '$kundenname' AND anrede = '$anrede'";

    // Die SQL-Abfrage ausführen und das Ergebnis in einer Variablen speichern
    $result = $conn->query($sql);

    // Wenn das Ergebnis der Abfrage nicht leer ist, bedeutet dies, dass der Kunde bereits existiert
    if ($result->num_rows > 0) {
        // Gib eine Fehlermeldung aus
        echo "Dieser Kunde existiert bereits.";
    } else {
        // SQL-Abfrage für das Einfügen eines neuen Kunden erstellen
        $sql = "INSERT INTO Kunde (name, anrede, email) VALUES ('$kundenname', '$anrede', '$email')";

        // Die SQL-Abfrage ausführen und prüfen, ob sie erfolgreich war
        if ($conn->query($sql) === TRUE) {
            // Erfolgsmeldung ausgeben
            echo "Sie haben erfolgreich den Kunden <strong>$kundenname</strong> angelegt.";
        } else {
            // Bei einem Fehler: Fehlermeldung ausgeben
            echo "Fehler beim Anlegen des Kunden: " . $conn->error;
        
        }
    }
}

// Search Customer: Suchen von Kunden
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    // Suchanfrage aus der URL holen
    $search_query = $_GET['search_query'];
    
    // SQL-Abfrage für die Suche nach einem Kunden erstellen
    $sql = "SELECT * FROM Kunde WHERE name LIKE '%$search_query%'";
    // Die SQL-Abfrage ausführen
    $result = $conn->query($sql);
    
    // Prüfen, ob Ergebnisse gefunden wurden
    if ($result->num_rows > 0) {
        // Gefundenen Kunden ausgeben
        while ($row = $result->fetch_assoc()) {
            // Kundendaten ausgeben
            echo "<h2>Kundendaten</h2>";
            echo "<ul>";
            echo "<li>Name: <strong>".$row['name']."</strong></li>";
            echo "<li>Anrede: <strong>".$row['anrede']."</strong></li>";
            echo "<li>Straße: <strong>".$row['strasse']."</strong></li>";
            echo "<li>Hausnummer: <strong>".$row['hausnummer']."</strong></li>";
            echo "<li>PLZ: <strong>".$row['plz']."</strong></li>";
            echo "<li>Ort: <strong>".$row['ort']."</strong></li>";
            echo "<li>Telefon: <strong>".$row['telefon']."</strong></li>";
            echo "<li>E-Mail: <strong>".$row['email']."</strong></li>";
            echo "</ul>";
        }
    } else {
        // Meldung ausgeben, dass kein Kunde gefunden wurde
        echo "Der Kunde ist nicht in der Datenbank.";
    
    }
}
// print methode 







// Verbindung zur Datenbank schließen
$conn->close();
?>