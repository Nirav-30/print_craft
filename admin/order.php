<?php

require_once "../api/db.php";

$sql = "SELECT * FROM orders ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin - Orders</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        header {
            background: #111;
            color: white;
            padding: 20px 40px;
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 40px auto;
        }

        h2 {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #111;
            color: white;
        }

        select {
            padding: 8px;
            border-radius: 5px;
        }

        .empty {
            text-align: center;
            padding: 30px;
        }

    </style>

</head>


<body>

<header>

    <h1>Print Craft - Admin Panel</h1>

</header>


<div class="container">

    <h2>All Orders</h2>


    <table>

        <thead>

            <tr>

                <th>Order ID</th>

                <th>Customer</th>

                <th>Email</th>

                <th>Phone</th>

                <th>Total</th>

                <th>Status</th>

                <th>Date</th>

            </tr>

        </thead>


        <tbody>

        <?php

        if ($result->num_rows > 0) {

            while ($order = $result->fetch_assoc()) {

        ?>

            <tr>

                <td>
                    #<?php echo $order["id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["customer_name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["email"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["phone"]); ?>
                </td>

                <td>
                    ₹<?php echo $order["total_amount"]; ?>
                </td>

                <td>

                    <select
                        onchange="updateStatus(
                            <?php echo $order['id']; ?>,
                            this.value
                        )">

                        <option
                            value="Pending"
                            <?php
                            if ($order["status"] == "Pending")
                                echo "selected";
                            ?>>
                            Pending
                        </option>

                        <option
                            value="Processing"
                            <?php
                            if ($order["status"] == "Processing")
                                echo "selected";
                            ?>>
                            Processing
                        </option>

                        <option
                            value="Shipped"
                            <?php
                            if ($order["status"] == "Shipped")
                                echo "selected";
                            ?>>
                            Shipped
                        </option>

                        <option
                            value="Delivered"
                            <?php
                            if ($order["status"] == "Delivered")
                                echo "selected";
                            ?>>
                            Delivered
                        </option>

                        <option
                            value="Cancelled"
                            <?php
                            if ($order["status"] == "Cancelled")
                                echo "selected";
                            ?>>
                            Cancelled
                        </option>

                    </select>

                </td>

                <td>
                    <?php echo $order["created_at"]; ?>
                </td>

            </tr>

        <?php

            }

        } else {

        ?>

            <tr>

                <td colspan="7" class="empty">
                    No orders found.
                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>

</div>


<script>

function updateStatus(orderId, status) {

    fetch("update_status.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            order_id: orderId,
            status: status
        })

    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            alert("Order status updated!");

        } else {

            alert(data.message);

        }

    })

    .catch(error => {

        console.error(error);

        alert("Something went wrong.");

    });

}

</script>


</body>

</html>