
<?php 
    include "data.php";

    $draftInvoices = array_filter($invoices, function($invoice){
        return $invoice('status') === 'draft';
    });

    if (!empty($draftInvoices)) {
        echo "<h1>Draft Invoices</h1>";
        echo "<table>";
        echo "<tr><th>Invoice ID</th><th>Date</th><th>Customer</th><th>Total</th></tr>";
        foreach ($draftInvoices as $invoice) {
            echo "<tr>";
            echo "<td>" . $invoice['id'] . "</td>";
            echo "<td>" . $invoice['date'] . "</td>";
            echo "<td>" . $invoice['customer'] . "</td>";
            echo "<td>" . $invoice['total'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>No Draft Invoices</h1>";
    }
?>
 

