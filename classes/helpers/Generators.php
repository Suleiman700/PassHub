<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/settings/db.php';

class Generators
{
    function __constructor() {}

    /**
     * receive table name and generate new primary key for inserting new record into it
     * @param string $_tableName
     * @return int
     */
    public function gen_table_primary_key(string $_tableName): int
    {
        global $conn;

        $query = "SELECT MAX(id) + 1 AS new_primary_key FROM $_tableName";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();
        echo '<pre>';
        print_r($results);
        echo '</pre>';
        return 1;
    }
}