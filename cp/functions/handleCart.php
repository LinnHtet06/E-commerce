
    


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
                if (isset($data['prod_id']) && isset($data['prod_qty'])) {
                    $prod_id = $data['prod_id'];
                    $prod_qty = $data['prod_qty'];
                    $userID = $_SESSION['auth_user']['c_id'];

                    $checkCart = "SELECT * FROM carts WHERE p_id='$prod_id' AND c_id='$userID'";
                    $checkResult = mysqli_query($conn, $checkCart);

                    if (mysqli_num_rows($checkResult) > 0) {
                        $response['status'] = 'alreadyexisting';
                    } else {
                        $sql = "INSERT INTO carts (pqty, p_id, c_id) VALUES ('$prod_qty','$prod_id','$userID')";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            $response['status'] = 201;
                        } else {
                            $response['status'] = 500;
                            $response['message'] = 'Failed to add product to cart';
                        }
                    }
                } else {
                    $response['status'] = 400;
                    $response['message'] = 'Product ID or quantity not set';
                }
                break;
            case "update":
                if (isset($data['prod_id']) && isset($data['prod_qty'])) {
                    $prod_id = $data['prod_id'];
                    $prod_qty = $data['prod_qty'];
                    $userID = $_SESSION['auth_user']['c_id'];
                    $checkCart = "SELECT * FROM carts WHERE p_id='$prod_id' AND c_id='$userID'";
                    $checkResult = mysqli_query($conn, $checkCart);

                    if (mysqli_num_rows($checkResult) > 0) {
                        $updateQuery="UPDATE carts SET pqty='$prod_qty' WHERE p_id='$prod_id'";
                        $queryRun=mysqli_query($conn,$updateQuery);
                        if($queryRun){
                            $response['status'] = 200;
                        }
                        else{
                            $response['status'] = 500;
                        }
                    } else {
                        echo "Something Went Wrong";
                    }
                } else {
                    $response['status'] = 400;
                    $response['message'] = 'Product ID or quantity not set';
                }
                break;


            case "delete":
                if (isset($data['cartId'])) {
                    $cartId = $data['cartId'];
                    $userID = $_SESSION['auth_user']['c_id'];

                    $checkCart = "SELECT * FROM carts WHERE cart_id='$cartId' AND c_id='$userID'";
                    $checkResult = mysqli_query($conn, $checkCart);

                    if (mysqli_num_rows($checkResult) > 0) {
                        $deletesql = "DELETE FROM carts WHERE cart_id='$cartId'";
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
                        $response['message'] = 'Cart item not found';
                    }
                } else {
                    $response['status'] = 400;
                    $response['message'] = 'Cart ID not set';
                }
                break;

            default:
                $response['status'] = 500;
                $response['message'] = 'Invalid scope';
                break;
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
