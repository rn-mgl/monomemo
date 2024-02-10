<?php session_start() ?>
<?php

include_once("../../database/conn.php");
include_once("../../utils/tokens.php");

?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $noteBy = $_SESSION["id"];

        $query = "SELECT note_uuid AS uuid, 
                    note_title AS title, 
                    note_content AS content, 
                    note_file AS file, 
                    note_from AS from_path,
                    'note' AS type,
                    date_created FROM notes
                    WHERE note_by = ?
                    AND note_from = '0'
                
                UNION

                SELECT folder_uuid AS uuid, 
                    folder_name AS title, 
                    null AS content, 
                    null AS file, 
                    folder_from AS from_path,
                    'folder' AS type,
                    date_created FROM folders
                    WHERE folder_by = ?
                    AND folder_from = '0'
                
                ORDER BY date_created DESC";

        $result = $conn->execute_query($query, [$noteBy, $noteBy]);

        if ($result->num_rows > 0) {
            $userFiles = array();
            while ($row = $result->fetch_assoc()) {
                $userFiles[] = $row;
            }
            echo json_encode($userFiles);
        } else {
            echo json_encode(array());
        }
    } catch (Exception $e) {
        header("Location: /client/pages/monomemo/home.php");
        die();
    }
}

?>