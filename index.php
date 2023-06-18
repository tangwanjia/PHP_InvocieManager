<?php
require 'functions.php';

function getStatusClass($status)
{
    switch ($status) {
        case 'draft':
            return 'bg-secondary text-white';
        case 'pending':
            return 'bg-warning text-dark';
        case 'paid':
            return 'bg-success text-white';
        default:
            return '';
    }
}

if(isset($_GET['status']))
{
    $filtered_invoices = getInvoices($_GET['status']);
}
else
{
    $filtered_invoices = getInvoices('all');
}

// function StatusId()
// {
//     global $db;
//     $sql = "SELECT * FROM invoices join statuses on statuses.id = invoice.status_id ";
//     $result = $db->query($sql);
//     $invoice = $result->fetchALL();

//     return $invoice;
//}

// Handle delete invoice

if (isset($_POST['delete_invoice'])) {
    var_dump($_POST);
    $invoiceNumber = $_POST['delete_invoice'];
    global $db;
    $delete = "delete from invoices where number = :invoice_number";
    $result = $db->prepare($delete);
    $result->execute([':invoice_number'=>$invoiceNumber]);
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Invoices</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="bg-dark text-white p-3">
        <h1>Invoice Manager</h1>
        <nav>
            <ul class="list-inline mb-0">
                <li class="list-inline-item"><a href="index.php?status=all" class="text-white">All</a></li>
                <li class="list-inline-item"><a href="index.php?status=draft" class="text-white">Draft</a></li>
                <li class="list-inline-item"><a href="index.php?status=pending" class="text-white">Pending</a></li>
                <li class="list-inline-item"><a href="index.php?status=paid" class="text-white">Paid</a></li>
                <li class="list-inline-item"><a href="add.php" class="text-white">Add</a></li>
            </ul>
        </nav>


    </header>
    <main class="main">
        <section class="invoice">
            <table>
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered_invoices as $invoice) : ?>
                        <tr>
                            <td><?php echo $invoice['number']; ?></td>
                            <td><?php echo $invoice['amount']; ?></td>
                            <td><?php echo $invoice['client']; ?></td>
                            <td><?php echo $invoice['email']; ?></td>
                            <td><?php echo $invoice['status']; ?></td>
                            <td><a href="update.php?number=<?php echo $invoice['number'] ?>">Edit</a></td>
                            
                            <td><form method="post">
                                <input type="hidden" name="delete_invoice" value="<?php echo $invoice['number'] ?>">
                                <button type="submit">Delete</button>                                
                            </form>
                            </td>

                         
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>