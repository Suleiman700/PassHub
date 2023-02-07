<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/settings/db.php';

class Categories
{
    function __construct() {}

    public function get_user_categories(string|int $_userId): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        $query = "SELECT * FROM categories WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_all(MYSQLI_ASSOC);

        // check if data found
        if ($stmt->num_rows) {
            $res['dataFound'] = true;
            $res['data'] = $results;
        }

        return $res;
    }

    public function get_category_info(string|int $_categoryId): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        $query = "SELECT * FROM categories WHERE id = '$_categoryId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        // check if data found
        if ($stmt->num_rows) {
            $res['dataFound'] = true;
            $res['data'] = $results;
        }

        return $res;
    }

    /**
     * update user category
     * @param string|int $_categoryId example: 1
     * @param string|int $_categoryUserId example: 1
     * @param array $_newCategoryData
     * @return true[]
     */
    public function update_category(string|int $_categoryId, string|int $_categoryUserId, array $_newCategoryData): array
    {
        global $conn;
        $res = array(
            'dataUpdated' => true
        );

        $name = $_newCategoryData['name'];
        $description = $_newCategoryData['description'];
        $color = $_newCategoryData['color'];

        $query = "UPDATE categories SET name='$name', description='$description', color='$color' WHERE id='$_categoryId' AND user_id='$_categoryUserId'";
        $stmt = mysqli_query($conn, $query);

        return $res;
    }

    public function create_category(string|int $_categoryUserId, array $_newCategoryData): array
    {
        global $conn;
        $res = array(
            'dataInserted' => false,
            'errors' => array()
        );

        // generate new row id
        $new_key = $this->gen_new_primary_key();

        $name = $_newCategoryData['name'];
        $description = $_newCategoryData['description'];
        $color = $_newCategoryData['color'];

        $query = "INSERT INTO categories (id, user_id, name, description, color) VALUES ($new_key, $_categoryUserId, '$name', '$description', '$color')";
        $result = mysqli_query($conn, $query);

        if (isset($result) && $result === true) {
            $res['dataInserted'] = true;
        }
        else {
            $res['dataInserted'] = false;
            $res['errors'][] = 'An error occurred';
        }

        return $res;
    }

    /**
     * generate new primary key for inserting new record into table
     * @return int
     */
    private function gen_new_primary_key(): int
    {
        global $conn;

        $query = "SELECT MAX(id) + 1 AS new_primary_key FROM categories";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        // if found new primary key
        if ($stmt->num_rows && !empty($results['new_primary_key'])) {
            return $results['new_primary_key'];
        }
        else {
            return 0;
        }
    }
}