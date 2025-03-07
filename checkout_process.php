<?php
session_start();
include "db.php";

if (isset($_SESSION["uid"])) {
    $f_name = mysqli_real_escape_string($con, $_POST["firstname"]);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $total_count = (int)$_POST['total_count'];
    $prod_total = (float)$_POST['total_price'];
    $user_id = (int)$_SESSION['uid'];

    // Get the next order_id
    $sql_max_order_id = "SELECT MAX(order_id) AS max_order_id FROM orders_info";
    $result_max_order_id = mysqli_query($con, $sql_max_order_id);
    $row_max_order_id = mysqli_fetch_assoc($result_max_order_id);
    $order_id = ($row_max_order_id['max_order_id'] !== null) ? (int)$row_max_order_id['max_order_id'] + 1 : 1;

    $ref = randomREF();

    // Insert into 'orders' table
    $sql_insert_order = "INSERT INTO orders (order_id, user_id, ref_id) VALUES (?, ?, ?)";
    $stmt_insert_order = mysqli_prepare($con, $sql_insert_order);
    mysqli_stmt_bind_param($stmt_insert_order, "iis", $order_id, $user_id, $ref);
    if (!mysqli_stmt_execute($stmt_insert_order)) {
        echo "Error inserting into orders table: " . mysqli_error($con);
        exit;
    }
    mysqli_stmt_close($stmt_insert_order);

    // Insert into 'orders_info' table
    $sql_insert_order_info = "INSERT INTO orders_info (order_id, user_id, f_name, email, address, prod_count, total_amt) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_order_info = mysqli_prepare($con, $sql_insert_order_info);
    mysqli_stmt_bind_param($stmt_insert_order_info, "iisssid", $order_id, $user_id, $f_name, $email, $address, $total_count, $prod_total);

    if (mysqli_stmt_execute($stmt_insert_order_info)) {
        // Loop through products and insert into 'order_products' table
        for ($i = 1; $i <= $total_count; $i++) {
            $prod_id = (int)$_POST['prod_id_' . $i];
            $prod_price = (float)$_POST['prod_price_' . $i];
            $prod_qty = (int)$_POST['prod_qty_' . $i];
            $sub_total = $prod_price * $prod_qty;

            $sql_insert_order_products = "INSERT INTO order_products (order_id, product_id, qty, amt) VALUES (?, ?, ?, ?)";
            $stmt_insert_order_products = mysqli_prepare($con, $sql_insert_order_products);
            mysqli_stmt_bind_param($stmt_insert_order_products, "iiid", $order_id, $prod_id, $prod_qty, $sub_total);

            if (!mysqli_stmt_execute($stmt_insert_order_products)) {
                echo "Error inserting into order_products table: " . mysqli_error($con);
                exit;
            }
            mysqli_stmt_close($stmt_insert_order_products);
        }

        // Delete cart items
        $del_sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt_delete_cart = mysqli_prepare($con, $del_sql);
        mysqli_stmt_bind_param($stmt_delete_cart, "i", $user_id);

        if (mysqli_stmt_execute($stmt_delete_cart)) {
            echo "<script>window.location.href='store.php'</script>";
        } else {
            echo "Error deleting from cart: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt_delete_cart);

    } else {
        echo "Error inserting into orders_info table: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt_insert_order_info);

} else {
    echo "<script>window.location.href='index.php'</script>";
}

function randomREF() {
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $text = '';
    for ($i = 0; $i < 10; $i++) {
        $text .= substr($str, rand(0, strlen($str) - 1), 1);
    }
    return $text;
}
?>