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
$tableHTML = "<table>";
$currentMonth = null;
$currentCustomer = null;

foreach ($result as $row) {
    $customer = $row['first_name'] . " " . $row['last_name'];
    $productsBought = explode("<br>", $row['Products_Bought']);
    $total = $row['Total'];
    $month = $row['Month'];

    // Display the month header
    if ($month != $currentMonth) {
        $tableHTML .= "<tr style='text-align: left'><th colspan='3'><h2>$month</h2></th></tr>";
        $tableHTML .= "<tr style='text-align: left'><th>Customer</th><th>Products Bought</th><th>Total</th></tr>";
        $currentMonth = $month;
        $currentCustomer = null;
    }

    // Display the customer details
    $tableHTML .= "<tr>";
    // Check if customer has changed
    if ($customer != $currentCustomer) {
        $tableHTML .= "<td rowspan='" . count($productsBought) . "'>$customer</td>";
        $currentCustomer = $customer;
    } else {
        $tableHTML .= "<td></td>"; // Empty cell for duplicate customer
    }

    // Display products bought
    foreach ($productsBought as $index => $product) {
        if ($index > 0) {
            $tableHTML .= "<tr>";
        }
        $tableHTML .= "<td>$product</td>";
        if ($index == 0) {
            $tableHTML .= "<td rowspan='" . count($productsBought) . "'>R $total</td>";
        }
        $tableHTML .= "</tr>";
    }
}

$tableHTML .= "</table>";
echo $tableHTML;

?>


</body>
</html>