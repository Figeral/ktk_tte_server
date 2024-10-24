<?php
class DatabaseDownloader
{
    public function downloadDatabaseDump()
    {
        // Create a temporary file to store the database dump
        $tempFile = tempnam(sys_get_temp_dir(), 'database_dump');

        // Execute mysqldump command to dump the database
        $command = "mysqldump --host=localhost --user=fitzgerard --password= Diablomanore237@localhost taskmatic > $tempFile";
        exec($command, $output, $returnValue);

        // Check if mysqldump was successful
        if ($returnValue === 0) {
            // Set headers for file download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="database_backup.sql"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($tempFile));

            // Read the temporary file and output its contents
            readfile($tempFile);

            // Delete the temporary file
            unlink($tempFile);

            // Exit script
            exit;
        } else {
            // If mysqldump failed, display an error message
            echo "Error: Unable to dump database.";
        }
    }
}
