<?php include_once("../../database/conn.php") ?>

<?php

    function getParent($folderID) {
        global $conn;
        $query = "SELECT * FROM folders WHERE
                    folder_id = ?";
        $result = $conn->execute_query($query, [$folderID]);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["folder_from"];
        }

        return 0;
    }

    function getChild($folderID) {
        global $conn;
        $query = "SELECT * FROM folders WHERE
                    folder_from = ?";
        $result = $conn->execute_query($query, [$folderID]);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["folder_id"];
        }

        return 0;
    }

    function getAllParents($parentID) {
        $allParents = array();

        while ($parentID && !in_array($parentID, $allParents)) {
            $allParents[] = $parentID;
            $parentID = getParent($parentID);
        }

        return $allParents;
    }

    function getAllChildren($childID) {
        $allChildren = array();

        while ($childID && !in_array($childID, $allChildren)) {
            $allChildren[] = $childID;
            $childID = getChild($childID);
        }

        return $allChildren;
    }

?>