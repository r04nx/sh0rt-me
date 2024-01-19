<?php

$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$value = end($parts);
// echo $value;
if (!$value == '') {
    include('db.php');
    $sql =  "SELECT longurl from urls WHERE shorturl = '$value';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (isset($row['longurl'])) {
        extract($row);
        // echo $longurl;
        header("Location: $longurl");
    } else {
        echo "<script>var notfound = '404';
                var notfound2 = 'URL not found'
        </script>";
    }
}


?>
<html>
<title>Sh0rt me - Link Shortener</title>
<link rel="icon" type="image/x-icon" href="assets/shortme.ico">
<script src='assets/tailwind.config.js'></script>

<style>
    body {

        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    button[type='submit']:hover {
        background-color: #1565c0;
    }

    button[type='submit']:active {
        background-color: #0d47a1;
    }
</style>
</head>

<body class='bg-gray-100'>
    <div class="container mx-auto" style=' zoom: 200%;'>

        <div class="flex flex-col items-center justify-center  mt-10 pt-5 bg-gray-100">
            <img src='assets/shortme.png' width='50px' height="50px">
            <h3 id='short' class="text-6xl font-bold text-red-600 "></h3>
            <label id='short2' class='mb-4'></label>
            <h1 class="text-3xl font-bold text-blue-600 mb-4">Sh0rt me</h1>
            <script>
                document.getElementById('short').innerHTML = notfound;
                document.getElementById('short2').innerHTML = notfound2;
            </script>
            <p class="text-lg text-gray-600 mb-8">Shorten and share your links effortlessly.</p>
            <div class="flex flex-col md:flex-row items-center">
                <form method="post" class="flex">
                    <input type="text" name="longurl" placeholder="Enter your long URL" class="py-2 px-4 rounded-l-md h-10 md:w-80 mb-4 md:mb-0" required>
                    <button type="submit" name="submit" value="Submit" class="py-2 px-4 rounded-r-md bg-blue-600 h-10 text-white transition duration-300 hover:bg-blue-700 focus:outline-none">Shorten</button>

                </form>
            </div>
            <div id='result' style='  zoom:70%; border-top: 1px solid black;border-bottom: 1px solid;' class="flex  hidden flex-col md:flex-row items-center">

                <input type="text" id='shorturl' name="longurl" value="https://sh0rtme.rf.gd" class="py-2 text-xl text-gray-600 bg-gray-100 px-4 h-10 md:w-80 mb-4 md:mb-0" required>
                <button type="submit" onclick='copyToClipboard()' name="submit" value="Submit" class="py-2 rounded-lg m-2 px-4 bg-blue-600 h-10 text-white transition duration-300 hover:bg-blue-700 focus:outline-none"> Copy </button>


            </div>
        </div>
    </div>




    <!-- <button onclick="">Show Success Alert</button>
  <button onclick="">Show Error Alert</button> -->

    <!-- Alert container -->
    <div id="alertContainer" class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
        <div id="alert" style='display:none' class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto">
            <div class="flex items-start justify-between px-4 py-3 border-b">
                <div class="flex items-center">
                    <div id='mark'></div>

                    <div id="alertTitle" class="ml-3 font-bold"></div>
                </div>

                <button onclick="dismissAlert()" class="text-gray-800 hover:text-gray-900 transition ease-in-out duration-150 focus:outline-none">
                    <svg class="fill-current h-6 w-6 text-gray-900" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                    </span>
            </div>
            </button>
        </div>
        <div id="alertMessage" class="px-4 py-2"></div>
    </div>
    </div>


    <script>
        function showAlert(mark_, title, message, color) {
            const alertContainer = document.getElementById("alertContainer");
            const alert = document.getElementById("alert");
            var mark = document.getElementById("mark");
            mark.innerHTML = mark_;


            const alertIcon = document.getElementById("alertIcon");
            const alertTitle = document.getElementById("alertTitle");
            const alertMessage = document.getElementById("alertMessage");
            alert.style.display = 'unset';
            // Set alert content and styling
            alertTitle.textContent = title;
            alertMessage.textContent = message;
            alert.classList.remove("bg-green-100", "bg-red-100");
            alert.classList.add(`bg-${color}-100`);


            // Show the alert
            alertContainer.style.display = "flex";

            // Show the alert
            alertContainer.style.display = "flex";
            alert.style.opacity = 1;

            // Fade away after 7 seconds
            setTimeout(() => {
                alert.style.opacity = 0;
                setTimeout(() => {
                    alertMessage.style.display = "none";
                }, 500);
            }, 7000);
        }

        function showSuccessAlert(message) {
            showAlert('<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>', "Success, url shorterned successfully!", message, "green");
        }

        function showErrorAlert(message) {
            showAlert("❌", message, '', "red");
        }

        function dismissAlert() {
            const alertContainer = document.getElementById("alertContainer");
            const alert = document.getElementById("alert");

            // Hide the alert
            alert.style.opacity = 0;
            setTimeout(() => {
                alertContainer.style.display = "none";
            }, 500);
        }
    </script>



    <script>
        function copyToClipboard() {
            const shortenLink = document.getElementById("shorturl");
            shortenLink.select();
            document.execCommand("copy");
        }
    </script>


</body>

</html>


<?php


if (isset($_POST['submit']) && isset($_POST['longurl'])) {
    $longurl = $_POST['longurl'];
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $domain = $_SERVER['HTTP_HOST'];

    if (filter_var($longurl, FILTER_VALIDATE_URL)) {

        $parsed_url = parse_url($longurl);

        if (strpos($parsed_url['host'], $domain) !== false) {
            echo "<script>showErrorAlert('Error, can not shorten this url') </script>";
        } else {
            include_once('db.php');
            $sql = "Select shorturl from urls where longurl = '$longurl';";
            $result = mysqli_query($conn, $sql);
            $row =  mysqli_fetch_assoc($result);
            if (isset($row['shorturl'])) {
                $url = $domain . "/" . $row['shorturl'];
                echo "<script> 
        document.getElementById('result').style.display = 'flex';
        document.getElementById('shorturl').value = '$url';
        showSuccessAlert('');
        </script>";
            } else {


                include('db.php');
                $shorturl = substr(uniqid(), -5);
                $sql = "INSERT into urls(longurl, shorturl) value('$longurl','$shorturl');";
                $url = $domain . "/" . $shorturl;



                if (mysqli_query($conn, $sql)) {
                    echo "<script> 
        document.getElementById('result').style.display = 'flex';
        document.getElementById('shorturl').value = '$url';
        showSuccessAlert('');
        </script>";
                }
            }
        }
    } else {
        echo "<script> showErrorAlert('Error, Please enter a valid url') </script>";
    }
}


?>