<?php
session_start();
include('../db/config.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

$response = [];

// Decode the JSON body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($_SESSION['auth'])) {
    if (isset($data['scope'])) {
        $scope = $data['scope'];
        switch ($scope) {
            case "add":
                if (isset($data['prod_id'])) {
                    $prod_id = $data['prod_id'];
                    $userID = $_SESSION['auth_user']['c_id'];

                    $checkWish = "SELECT * FROM wishlist WHERE p_id='$prod_id' AND c_id='$userID'";
                    $checkResult = mysqli_query($conn, $checkWish);

                    if (!$checkResult) {
                        $response['status'] = 500;
                        $response['message'] = 'Failed to check wishlist: ' . mysqli_error($conn);
                        echo json_encode($response);
                        exit;
                    }

                    if (mysqli_num_rows($checkResult) > 0) {
                        $response['status'] = 'alreadyexisting';
                    } else {
                        $sql = "INSERT INTO wishlist (p_id, c_id) VALUES ('$prod_id', '$userID')";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            $response['status'] = 201;
                        } else {
                            $response['status'] = 500;
                            $response['message'] = 'Failed to add product to wishList: ' . mysqli_error($conn);
                        }
                    }
                } else {
                    $response['status'] = 400;
                    $response['message'] = 'Product ID not set';
                }
                break;
                case "delete":
                    if (isset($data['wID'])) {
                        $wID = $data['wID'];
                        $userID = $_SESSION['auth_user']['c_id'];
    
                        $checkCart = "SELECT * FROM wishList WHERE wish_id='$wID' AND c_id='$userID'";
                        $checkResult = mysqli_query($conn, $checkCart);
    
                        if (mysqli_num_rows($checkResult) > 0) {
                            $deletesql = "DELETE FROM wishList WHERE wish_id='$wID'";
                            $result = mysqli_query($conn, $deletesql);
                            if ($result) {
                                $response['status'] = 201;
                                $response['message'] = 'Successfully deleted product from cart';
                            } else {
                                $response['status'] = 500;
                                $response['message'] = 'Failed to delete product from cart';
                            }
                        } else {
                            $response['status'] = 404;
                            $response['message'] = 'Wish item not found';
                        }
                    } else {
                        $response['status'] = 400;
                        $response['message'] = 'Wish ID not set';
                    }
                    break;

            default:
                $response['status'] = 500;
                $response['message'] = 'Invalid scope';
        }
    } else {
        $response['status'] = 400;
        $response['message'] = 'Scope not set';
    }
} else {
    $response['status'] = 401;
    $response['message'] = 'Unauthorized';
}

// Output the JSON response
echo json_encode($response);
?>
