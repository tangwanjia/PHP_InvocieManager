<?php
    require "data.php";

    $status = isset($_GET['status']) ? $_GET['status'] : 'index';

    // Use a switch statement to determine the page content
    switch ($status) {
        case 'index':
            // Page: Index
            $title = 'List of Invoices';
            $invoice = $invoices; // Display all invoices
            break;
        case 'draft':
            // Page: Draft
            $title = 'Draft Invoices';
            $invoices = array_filter($invoices, function($invoice) {
                return $invoice['status'] == 'draft';
            });
            break;
        case 'paid':
            // Page: Paid
            $title = 'Paid Invoices';
            $invoices = array_filter($invoices, function($invoice) {
                return $invoice['status'] == 'paid';
            });
            break;
        case 'pending':
            // Page: Pending
            $title = 'Pending Invoices';
            $invoices = array_filter($invoices, function($invoice) {
                return $invoice['status'] == 'pending';
            });
            break;
    }

    function getInvoiceNumber ($length = 5) {
        $letters = range('A', 'Z');
        $number = [];
        
        for ($i = 0; $i < $length; $i++) {
            $randomwNumber = mt_rand(0, count($letters));
            array_push($number, $letters[$randomwNumber]);
        }
        return implode($number);
    } 

    if(isset($_POST['client'])){
        array_push($invoices, [
            'number' => getInvoiceNumber(),
            'client' => $_POST['client'],
            'email' => $_POST['email'],
            'amount' => $_POST['amount'],
            'status' => $_POST['status']
        ]);

        $_SESSION['invoices'] =$invoices;

    }



?>

<!DOCTYPE html>
<html>
<head>
    <title>List of Invoices</title>
    <link rel="stylesheet" href="style.css">

    <style>
       
    </style>
</head>
<body>
    <h1>Invoices Manager</h1>
    <nav>
        <ul>
            <li><a href="index.php">Index</a></li>
            <li><a href="index.php?status=draft">Draft</a></li>
            <li><a href="index.php?status=paid">Paid</a></li>
            <li><a href="index.php?status=pending">Pending</a></li>
            <li><a href="add.php">Add</a></li>
        </ul>
    </nav>
    <table>
        <tr>
            <th>number</th>
            <th>amount</th>
            <th>status</th>
            <th>client</th>
            <th>email</th>
        </tr>    
    <?php
        
        
        // Output the invoices
        foreach ($invoices as $invoice) {
            echo "<tr>";
            echo "<td>{$invoice['number']}</td>";
            echo "<td>{$invoice['amount']}</td>";
            echo "<td>{$invoice['status']}</td>";
            echo "<td>{$invoice['client']}</td>";
            echo "<td>{$invoice['email']}</td>";
            echo "</tr>";
        }
    
    ?> 
                

</body>
    
</html>