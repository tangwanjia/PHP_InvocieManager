<!DOCTYPE html>
<html>
<head>
    <title>Invoices </title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Invoices Management</h1>
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
        ?>
    </table>
</body>
</html>

         