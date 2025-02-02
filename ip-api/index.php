require_once 'config.php';

$apiKey = 'YOUR_API_KEY';
$ip = $_SERVER['REMOTE_ADDR'];
$url = "https://helpdesk.ca/ip-api/api/v1.php?key=$apiKey&ip=$ip";
$response = file_get_contents($url);
$data = json_decode($response, true);

$geo = $data['geo'];
$weather = $data['weather'];

$date = new DateTime('now', new DateTimeZone($geo['timezone']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Geolocation API Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Your existing styles */
    </style>
</head>
<body>
<!-- Your existing HTML content -->
</body>
</html>
