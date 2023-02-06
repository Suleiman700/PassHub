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

    public function update_category(string|int $_categoryId, string|int $_categoryUserId, array $_newCategoryData):array
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
}