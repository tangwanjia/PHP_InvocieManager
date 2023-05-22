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
        <li><a href="draft.php">draft</a></li>
        <li><a href="paid.php">paid</a></li>
        <li><a href="pending.php">pending</a></li>
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
            require_once 'data.php';
            // List data for all invoices
            foreach ($invoices as $invoice) {
                echo "<tr>";
                echo "<td>" . $invoice['number'] . "</td>";          
                echo "<td>" . $invoice['amount'] . "</td>";
                echo "<td>" . $invoice['status'] . "</td>";
                echo "<td>" . $invoice['client'] . "</td>";
                echo "<td>" . $invoice['email'] . "</td>";
                echo "</tr>";
            }
                echo "<tr>";
                echo "<td>" . $invoice['number'] . "</td>";          
                echo "<td>" . $invoice['amount'] . "</td>";
                echo "<td>" . $invoice['status'] . "</td>";
                echo "<td>" . $invoice['client'] . "</td>";
                echo "<td>" . $invoice['email'] . "</td>";
                echo "</tr>";
                
        ?>
    </table>
    </body>
</html>