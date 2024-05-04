<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit('Access Denied: You do not have permission to perform this action.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <div>
        <!-- Use links to redirect to specific pages for each action -->
        <a href="add_webinar.php" class="button">Tambah Seminar</a>
        <a href="edit_webinar.php" class="button">Edit Seminar</a>
        <a href="delete_webinar.php" class="button">Hapus Seminar</a>
    </div>
<style>
    body {
        background-color: #242424; /* Dark background color for the page */
        color: white; /* Text color */
        font-family: Arial, sans-serif; /* Font family */
        margin: 0; /* Remove default margin */
        height: 100vh; /* Full viewport height */
        display: flex; /* Use flexbox for layout */
        flex-direction: column; /* Stack elements vertically */
        justify-content: center; /* Center content vertically */
        align-items: center; /* Center content horizontally */
    }

    h2 {
        text-align: center; /* Center align heading */
        margin-bottom: 20px; /* Space below the heading */
    }

    .container {
        width: 100%; /* Full width of the container */
        max-width: 600px; /* Max width to prevent overly wide elements on large screens */
        text-align: center; /* Center align text and children */
        display: flex; /* Use flexbox */
        flex-direction: column; /* Stack children vertically */
        align-items: center; /* Center children horizontally */
    }

    .button {
        background-color: #006eff; /* Blue background color */
        color: white; /* Text color */
        padding: 10px 20px; /* Padding around the text */
        margin: 10px; /* Space around the button */
        border: none; /* No border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        font-size: 16px; /* Font size */
        text-decoration: none; /* No underline */
        display: inline-block; /* Allow placement next to other elements */
        
    }

    .button:hover {
        background-color: #0056b3; /* Darker shade of blue on hover */
        
    }



    @media screen and (max-width: 600px) {
        .button {
            width: 90%; /* Slightly narrower buttons on small screens */
            padding: 12px 0; /* Adequate padding */
        }
    }

    .logout-btn {
        position: absolute;
        bottom: 20px; /* Position at the bottom right corner */
        right: 20px;
    }
</style>

</body>
</html>
