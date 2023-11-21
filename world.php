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

    // Check if the 'lookup' parameter is set to 'cities'
    $lookupType = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if (!empty($country)) {
        $searchCountry = '%' . $country . '%';

        if ($lookupType === 'cities') {
            // Query for our cities
            $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name
                                   FROM cities
                                   JOIN countries ON cities.country_code = countries.code
                                   WHERE countries.name LIKE :country");
        } else {
            // Query for our countries
            $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        }

        $stmt->bindParam(':country', $searchCountry, PDO::PARAM_STR);
    } else {
        // Fetch all countries when 'country' is empty
        $stmt = $conn->prepare("SELECT * FROM countries");
    }

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output HTML table
    echo '<style>';
    echo 'table {border-collapse: collapse; width: 100%;}';
    echo 'th, td {border: 1px solid #dddddd; text-align: left; padding: 8px;}';
    echo 'th {background-color: #f2f2f2;}';
    echo '</style>';

    echo '<table>';
    if ($lookupType === 'cities') {
        // Table header for cities
        echo '<thead><tr><th>City Name</th><th>Country Name</th><th>District</th><th>Population</th></tr></thead>';
    } else {
        // Table header for countries
        echo '<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>';
    }
    echo '<tbody>';

    foreach ($results as $row) {
        echo '<tr>';
        if ($lookupType === 'cities') {
            // Table row for cities
            echo '<td>' . $row['city_name'] . '</td>';
            echo '<td>' . $row['country_name'] . '</td>';
            echo '<td>' . $row['district'] . '</td>';
            echo '<td>' . $row['population'] . '</td>';
        } else {
            // Table row for countries
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['continent'] . '</td>';
            echo '<td>' . $row['independence_year'] . '</td>';
            echo '<td>' . $row['head_of_state'] . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} catch (PDOException $e) {
    // Handle database connection errors
    echo 'Connection failed: ' . $e->getMessage();
}
?>
