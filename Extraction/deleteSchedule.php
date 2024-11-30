<?php

require_once '../config.php';

$delete_sql = "DELETE FROM subject";

if ($db->query($delete_sql) === TRUE) {
    header("Location: ../index.php?deleted=true");
    exit;
} else {
    echo "Chyba pri vymazavani dat " . $db->error;
}

?>
