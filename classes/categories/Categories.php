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

        $query = "SELECT categories.*, COUNT(passwords.id) AS passwords_count
                    FROM categories
                    LEFT JOIN passwords ON categories.id = passwords.category_id
                    WHERE categories.user_id = '$_userId'
                    GROUP BY categories.id";
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

        $_categoryId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_categoryId)));

//        $query = "SELECT * FROM categories WHERE id = '$_categoryId'";
        $query = "SELECT categories.*, COUNT(passwords.id) AS password_count
                    FROM categories
                    LEFT JOIN passwords ON categories.id = passwords.category_id
                    WHERE categories.id = '$_categoryId'
                    GROUP BY categories.id";
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

    public function delete_category(string|int $_categoryId): array
    {
        global $conn;
        $res = array(
            'dataDeleted' => false,
            'errors' => array()
        );

        $_categoryId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_categoryId)));

        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $_categoryId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $res['dataDeleted'] = true;
        } else {
            // echo "Insert query failed: " . mysqli_stmt_error($stmt);

            $res['errors'][] = array(
                'error' => $ERROR_CODES['CATEGORIES']['DELETE']['QUERY_FAILED']['NAME'],
                'errorCode' => $ERROR_CODES['CATEGORIES']['DELETE']['QUERY_FAILED']['CODE'],
            );
        }
        mysqli_stmt_close($stmt);

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