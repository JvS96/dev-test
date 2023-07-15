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
$monthlyCustomers = array(); // Array to store customers for each month

// Iterate over the query results and populate the $monthlyCustomers array
while ($row = $result->fetch_assoc()) {
    $customer = $row['first_name'] . " " . $row['last_name'];
    $productsBought = explode("<br>", $row['Products_Bought']);
    $total = $row['Total'];
    $month = $row['Month'];

    // Create a new customer entry for the month if it doesn't exist
    if (!isset($monthlyCustomers[$month])) {
        $monthlyCustomers[$month] = array();
    }

    // Add the customer and their products bought to the respective month's entry
    $monthlyCustomers[$month][] = array(
        'customer' => $customer,
        'products' => $productsBought,
        'total' => $total
    );
}

// Sort the customers in each month's entry based on their total spending
foreach ($monthlyCustomers as $month => &$customers) {
    usort($customers, function ($a, $b) {
        return $b['total'] - $a['total'];
    });
}

// Display the sorted customers for each month
echo "<table>";

foreach ($monthlyCustomers as $month => $customers) {
    echo "<tr style='text-align: left'><th colspan='3'><h2>$month</h2></th></tr>";
    echo "<tr style='text-align: left'><th>Customer</th><th>Products Bought</th><th>Total</th></tr>";

    foreach ($customers as $customer) {
        $customerName = $customer['customer'];
        $productsBought = $customer['products'];
        $customerTotal = $customer['total'];

        echo "<tr>";
        echo "<td>$customerName</td>";

        // Display products bought
        echo "<td>";
        foreach ($productsBought as $index => $product) {
            echo $product;
            if ($index < count($productsBought) - 1) {
                echo "<br>"; // Add line break between products
            }
        }
        echo "</td>";

        echo "<td>R $customerTotal</td>";
        echo "</tr>";
    }
}

echo "</table>";

?>
</body>
</html>