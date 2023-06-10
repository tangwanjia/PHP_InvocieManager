        <?php  
            require "template.php";          
            include "data.php";
           
            foreach($invoices as $invoice ){
              echo "<tr>";
              echo "<td>" . $invoice['number'] ."</td>";
              echo "<td>" . $invoice['amount'] . "</td>";
              echo "<td>" . $invoice['status'] . "</td>";
              echo "<td>" . $invoice['client'] . "</td>";
              echo "<td>" . $invoice['email'] . "</td>";
              echo "</tr>";
            }
        ?>              
        
    </body>
