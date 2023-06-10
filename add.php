 <?php
    require "data.php"
 ?>
 
 <!DOCTYPE html>
 <html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width",
        initial-scale=1.0>
        <title>Add New Client</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="main">
        <h1>Invoices Manager</h1>
        <nav>
        <ul>
            <li><a href="index.php">Index</a></li>
            <li><a href="index.php?status=draft">Draft</a></li>
            <li><a href="index.php?status=paid">Paid</a></li>
            <li><a href="index.php?status=pending">Pending</a></li>
        </ul>
    </nav>
    <form class="form" method="post" action="index.php"> 

        <h3>Client Name </h3>
        <input type="text" class="form-control" name="client"
            placeholder="Client Name" required> </br></br>

        <h3>Client Email</h3>
        <input type="text" class="form-control" name="email"
            placeholder="Client Email" required></br></br>     
        <?php
        ?>

        <h3>Invoice Amount</h3>
        <input type="text" class="form-control" name="amount"
            placeholder="Invoice Amount" required> </br></br>
        
        <h3>Invoice Status</h3>
        <select class="form-control" name="status">
            <option value="">Select A Status</option>
            <?php foreach($statuses as $status):?>
            <option value="<?php echo $status; ?>">
                <?php echo $status; ?></br></br>
            </option>
            <?php endforeach ;?>
        </select></br></br>

        <button type="submit" class="button">submit</button>
            
    </form>
    </main>
</body>
 </html>