<?php
    
    if(array_key_exists('submit', $_GET)){
        // Check whether the input is empty
        if (!$_GET['city']) {
            $error = "Sorry, your Input Field is empty!";
        }
        else if ($_GET['city']) {
            $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".
            $_GET['city']."&appid=97fc192bb7eb22696f4226e7c30129cb");
                $weatherArray = json_decode($apiData, true);
                if ($weatherArray['cod'] == 200){
                    // Conversion of Kelvin to Celcius
                    $tempCelcius = $weatherArray['main']['temp'] - 273;
                    $weather = "<b>".$weatherArray['name']. ", ".$weatherArray['sys']['country']. 
                    " : " .intval($tempCelcius). "&deg;C</b> <br>";
                    $weather .= "<b>Weather Condition : </b>" .$weatherArray['weather']['0']['description']. "<br>";
                    $weather .= "<b>Atmospheric Pressure : </b>" .$weatherArray['main']['pressure']." hPa <br>";
                    $weather .= "<b>Wind Speed : </b>" .$weatherArray['wind']['speed']." ms<sup>-1</sup> <br>";
                    $weather .= "<b>Cloudness : </b>" .$weatherArray['clouds']['all']." % <br>";
                    date_default_timezone_set('UTC');
                    $sunrise = $weatherArray['sys']['sunrise'];
                    $weather .= "<b>Sunrise : </b>" .date("g:i a", $sunrise) ."<br>";
                    $weather .= "<b>Current Time : </b>" .date("F j, Y, g:i a");
                }
                else {
                    $error = "The city entered is not valid";
                }
                
        }
    }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Weather Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">
        <h1>Weather Report</h1>

        <form action="" method="GET">
            <label for="city" style="padding-bottom:20px;">Enter the City</label>
            <p><input type="text" name="city" id="city" placeholder=" City Name"></p>
            <button type="submit" name="submit" class="btn btn-success">Submit</button>

            <div class="output mt-3">
                <?php 

                    if ($weather) {
                        echo '<div class="alert alert-success" role="alert">
                        '. $weather.'
                        </div>';
                    }
                    else if ($error) {
                        echo '<div class="alert alert-danger" role="alert">
                        '. $error.'
                        </div>';
                    }

                ?>
            </div>
        </form>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>

</body>

</html>