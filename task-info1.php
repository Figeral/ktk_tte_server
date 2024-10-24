<?php
if(isset($_GET['download'])){
    // Include the class file
    require_once 'DatabaseDownloader.php';

    // Create an instance of DatabaseDownloader
    $downloader = new DatabaseDownloader();

    // Call the downloadDatabaseDump() method to download the database dump
    $downloader->downloadDatabaseDump();
}
?>
