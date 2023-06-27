<?php
require 'data.php';

// to get invoice information from the invoice number in the query string to pre fill the form
$invoiceNumber = $_GET['number'];
$invoice = current(array_filter($invoices, function ($invoice) use ($invoiceNumber) {
    return $invoice['number'] === $invoiceNumber;
}));

if (empty($invoice)) {
    echo 'Invalid invoice number.';
    exit;
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $client = $_POST['client'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    if (empty($client)) {
        $errors['client'] = 'Client is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $client)) {
        $errors['client'] = 'Must contain only letters and spaces and cannot be more than 255 characters';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Must be a properly formatted email address';
    }

    if (empty($amount)) {
        $errors['amount'] = 'Amount is required';
    } elseif (!is_numeric($amount)) {
        $errors['amount'] = 'Must be a number';
    }

    if (empty($status)) {
        $errors['status'] = 'Status is required';
    } elseif (!in_array($status, ['draft', 'pending', 'paid'])) {
        $errors['status'] = 'Must be either "draft", "pending", or "paid"';
    }

    if (empty($errors)) {
        // Update invoice
        global $db;

        $index = array_search($_POST['status'],array_column($statuses,'status')) + 1;
        var_dump($index);

        $sql = "update invoices 
                set client = :client,email = :email,amount = :amount,status_id = :status
                where number = :invNum";
            $result = $db->prepare($sql);
            $result -> execute([
                ':invNum' => $_POST['inv'],
                ':client' => $_POST['client'],
                ':email' => $_POST['email'],
                ':amount' => $_POST['amount'],
                ':status' => $index,
            ]);

        saveFile($invoice['status']);
        
        // Redirect to index.php
        header('Location: index.php');
        exit;
    }
} else {
    $client = $invoice['client'];
    $email = $invoice['email'];
    $amount = $invoice['amount'];
    $status = $invoice['status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <h1 class="m-0">Invoice Manager</h1>
        <nav>
            <ul class="list-inline mb-0">
                <li class="list-inline-item"><a href="index.php" class="text-white">Back</a></li>
            </ul>
        </nav>
    </header>
    <main class="p-3">
        <h2>Update Invoice</h2>
        <form method="POST">
            <div class="form-group">
                <input type="hidden" name="inv" value="<?php echo $_GET['number']; ?>">
                <label for="client">Client:</label>
                <input type="text" id="client" name="client" required class="form-control" value="<?php echo $client; ?>">
                <?php if (isset($errors['client'])) : ?>
                    <small class="text-danger"><?php echo $errors['client']; ?></small>
                <?php endif; ?>
            </div>
            <br>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-control" value="<?php echo $email; ?>">
                <?php if (isset($errors['email'])) : ?>
                    <small class="text-danger"><?php echo $errors['email']; ?></small>
                <?php endif; ?>
            </div>
            <br>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required class="form-control" value="<?php echo $amount; ?>">
                <?php if (isset($errors['amount'])) : ?>
                    <small class="text-danger"><?php echo $errors['amount']; ?></small>
                <?php endif; ?>
            </div>
            <br>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required class="form-control">
                    <option value="draft" <?php echo $status === 'draft' ? 'selected' : ''; ?> class="bg-secondary text-white">Draft</option>
                    <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?> class="bg-warning">Pending</option>
                    <option value="paid" <?php echo $status === 'paid' ? 'selected' : ''; ?> class="bg-success text-white">Paid</option>
                </select>
                <?php if (isset($errors['status'])) : ?>
                    <small class="text-danger"><?php echo $errors['status']; ?></small>
                <?php endif; ?>
            </div>
            <br>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>   
</body>
</html>
