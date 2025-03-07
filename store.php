<?php
include 'header.php';
include '../db.php'; // Include your database connection

// JavaScript to prevent back button and backspace
?>
<script id="jsbin-javascript">
    (function (global) {
        if (typeof (global) === "undefined") {
            throw new Error("window is undefined");
        }
        var _hash = "!";
        var noBackPlease = function () {
            global.location.href += "#";
            global.setTimeout(function () {
                global.location.href += "!";
            }, 50);
        };
        global.onhashchange = function () {
            if (global.location.hash !== _hash) {
                global.location.hash = _hash;
            }
        };
        global.onload = function () {
            noBackPlease();
            document.body.onkeydown = function (e) {
                var elm = e.target.nodeName.toLowerCase();
                if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                    e.preventDefault();
                }
                e.stopPropagation();
            };
        };
    })(window);
</script>

<div class="main main-raised">
    <div class="section">
        <div class="container">
            <div class="row">
                <div id="aside" class="col-md-3">
                    <div id="get_brand"></div>
                </div>
                <div id="store" class="col-md-9">
                    <div class="store-filter clearfix"></div>
                    <div class="row" id="product-row">
                        <div class="col-md-12 col-xs-12" id="product_msg"></div>
                        <div id="get_product">
                            </div>
                    </div>
                    <div class="store-filter clearfix">
                        <ul class="store-pagination" id="pageno">
                            <li><a class="active" href="#aside">1</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";

// Order saving logic (example - refine as needed)
if (isset($_POST['place_order'])) {
    // Collect order details from POST data
    $user_id = $_SESSION["uid"]; // Assuming user is logged in
    $total_amt = $_POST['total_amount']; // Get total amount from form
    $payment_method = $_POST['payment_method']; // Get payment method from form
    $address = $_POST['address']; // get address from form
    $trx_id = uniqid(); // Generate a unique transaction ID

    // Insert order into orders table
    $insert_order = mysqli_query($con, "INSERT INTO orders (user_id, total_amt, payment_method, address, trx_id, order_date, order_status) VALUES ($user_id, $total_amt, '$payment_method', '$address','$trx_id', NOW(), 'Pending')");

    if ($insert_order) {
        $order_id = mysqli_insert_id($con); // Get the last inserted order ID

        // Insert order items into order_items table
        $cart_items = json_decode($_POST['cart_items'], true); // Assuming cart items are passed as JSON

        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $qty = $item['qty'];
            $price = $item['price'];

            mysqli_query($con, "INSERT INTO order_items (order_id, product_id, qty, price) VALUES ($order_id, $product_id, $qty, $price)");
        }

        echo "<script>alert('Order placed successfully. Order ID: $order_id');</script>";

    } else {
        echo "<script>alert('Error placing order.');</script>";
    }
}
?>

<script>
//Example of how to send the cart data and order information to the server.
function placeOrder(){
    let total_amount = 100; //example, get the total amount from the cart.
    let payment_method = "credit card"; //example, get payment method from the form.
    let address = "123 main street"; //example, get address from the form.
    let cart_items = JSON.stringify([{'product_id':1,'qty':2,'price':50}]); //example, get the cart items and convert to JSON.

    let form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; //current page

    let totalAmountInput = document.createElement('input');
    totalAmountInput.type = 'hidden';
    totalAmountInput.name = 'total_amount';
    totalAmountInput.value = total_amount;
    form.appendChild(totalAmountInput);

    let paymentMethodInput = document.createElement('input');
    paymentMethodInput.type = 'hidden';
    paymentMethodInput.name = 'payment_method';
    paymentMethodInput.value = payment_method;
    form.appendChild(paymentMethodInput);

    let addressInput = document.createElement('input');
    addressInput.type = 'hidden';
    addressInput.name = 'address';
    addressInput.value = address;
    form.appendChild(addressInput);

    let cartItemsInput = document.createElement('input');
    cartItemsInput.type = 'hidden';
    cartItemsInput.name = 'cart_items';
    cartItemsInput.value = cart_items;
    form.appendChild(cartItemsInput);

    let placeOrderInput = document.createElement('input');
    placeOrderInput.type = 'hidden';
    placeOrderInput.name = 'place_order';
    placeOrderInput.value = '1';
    form.appendChild(placeOrderInput);

    document.body.appendChild(form);
    form.submit();
}
</script>