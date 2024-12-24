<?php
$conn = mysqli_connect("localhost", "root", "", "sh0rtme");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function sanitize_input($conn, $input) {
    return mysqli_real_escape_string($conn, strip_tags(trim($input)));
}
?>