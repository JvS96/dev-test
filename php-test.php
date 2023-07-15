<?php
/**
 * QUESTION 3
 *
 * For each month that had sales show a list of customers ordered by who spent the most to who spent least.
 * If the totals are the same then sort by customer.
 * If a customer has multiple products then order those products alphabetical.
 * Months with no sales should not show up.
 * Show the name of the customer, what products they bought and the total they spent.
 * Only show orders with the "Payment received" and "Dispatched" status.
 * If there are no results, then it should just say "There are no results available."
 *
 * Please make sure your code runs as effectively as it can.
 *
 * See test3.html for desired result.
 */
?>
<?php
//$con holds the connection
require_once('db.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Test3</title>
</head>
<body>
<h1>Top Customers per Month</h1>

<?php

echo "<table>";

$currentMonth = null;
$currentCustomer = null;

while ($row = $result->fetch_assoc()) {
    $customer = $row['first_name'] . " " . $row['last_name'];
    $productsBought = explode("\r\n", $row['Products_Bought']); // Split the products by newline character
    $total = $row['Total'];
    $month = $row['Month'];

    // Display the month header
    if ($month != $currentMonth) {
        echo "<tr style='text-align: left'><th colspan='3''><h2>$month</h2></th></tr>";
        echo "<tr style='text-align: left'><th>Customer</th><th>Products Bought</th><th>Total</th></tr>";
        $currentMonth = $month;
        $currentCustomer = null;
    }

    // Display the customer details
    echo "<tr>";
    // Check if customer has changed
    if ($customer != $currentCustomer) {
        echo "<td rowspan='".count($productsBought)."'>$customer</td>"; // Set rowspan for first row of customer
        $currentCustomer = $customer;
    } else {
        echo "<td></td>"; // Empty cell for duplicate customer
    }
    // Display products bought
    foreach ($productsBought as $index => $product) {
        if ($index > 0) {
            echo "<tr>"; // Start new row for each additional product
        }
        echo "<td>$product</td>";
        if ($index == 0) {
            echo "<td rowspan='".count($productsBought)."'>R $total</td>"; // Set rowspan for first row of products
        }
        echo "</tr>";
    }
}
echo "</table>";

?>


</body>
</html>