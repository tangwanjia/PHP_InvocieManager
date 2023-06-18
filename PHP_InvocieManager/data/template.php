    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.@">

        <title>All Invocies</title>
        <div class="title">
            <h1>All Invocies</h1>   
        </div>            
        <style>
           
        </style>
    </head>
    <body>    
    <nav class="navigation">
        <ul>
            <li><a href ="index.php">index</a></li>
            <li><a href= "draft.php">draft</a></li>
            <li><a href="pending.php">Pending</a></li>
            <li><a href="paid.php">Paid</a></li>
        </ul>
    </nav>
    <table class="In">
       <thead>
        <tr>
        <th>number</th>
        <th>amount</th>
        <th>status</th>
        <th>client</th>
        <th>email</th>
        </tr>      
    </thead>     

    <?php
    
    $paidInvoices = array_filter($invoices,function($invoice){
        global $status;   
        return $invoice['status'] == $status;
        });

        foreach ($paidInvoices as $invoice){
            echo "<tr>";
            echo "<td>". $invoice ['number']."</td>";
            echo "<td>". $invoice ['amount']. "</td>";
            echo "<td>". $invoice ['status']. "</td>";
            echo "<td>". $invoice ['client']. "</td>";
            echo "<td>". $invoice ['email']. "</td>";
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