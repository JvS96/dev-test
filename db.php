<?php
$con = mysqli_connect("localhost","root","","devtest");

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

#Query Section
$customerData = "SELECT users.first_name, users.last_name, GROUP_CONCAT(products.product SEPARATOR '<br>') AS Products_Bought, SUM(products.price) AS Total, DATE_FORMAT(orders.order_date, '%M %Y') AS Month
        FROM orders
        INNER JOIN users ON orders.user_id = users.id
        INNER JOIN order_items ON orders.id = order_items.order_id
        INNER JOIN products ON order_items.product_id = products.id
        INNER JOIN statuses ON orders.order_status_id = statuses.id
        WHERE statuses.status_name IN ('Payment received', 'Dispatched')
        GROUP BY orders.id, users.first_name, users.last_name, Month
        ORDER BY orders.order_date ASC";

$result = $con->query($customerData);
