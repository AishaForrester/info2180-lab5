<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Attempt to establish a connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Check if the 'country' parameter is set in the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // Use a prepared statement to prevent SQL injection
    if (!empty($country)) {
        // Partial match using LIKE when 'country' is not empty
        $searchCountry = '%' . $country . '%';
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindParam(':country', $searchCountry, PDO::PARAM_STR);
    } else {
        // Fetch all countries when 'country' is empty
        $stmt = $conn->prepare("SELECT * FROM countries");
    }

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <ul>
        <?php foreach ($results as $row): ?>
            <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php
} catch (PDOException $e) {
    // Handle database connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>
