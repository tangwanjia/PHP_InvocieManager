
<?php
require_once 'data.php';

function getInvoiceNumber($length = 5) {
    $letters = range('A', 'Z');
    $number = [];

    for ($i = 0; $i < $length; $i++) {
        array_push($number, $letters[rand(0, count($letters) - 1)]);
    }
    return implode($number);
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
        
        global $db;

        $status_id = array_search($_POST['status'], array_column($statuses,'status')) + 1;
        //var_dump($status_id);

            // create a new invoice
        $sql = "INSERT INTO invoices (number, client, email, amount, status_id)
                VALUES (:num, :client, :email, :amount, :status_id)";
            $result = $db ->prepare($sql);
            $result->execute([
                ':num'=> getInvoiceNumber(),
                ':client' => $_POST['client'],
                ':email' => $_POST['email'],
                ':amount' => $_POST['amount'],
                ':status_id' => $status_id,
            ]);
              
        // Redirect to index.php
        header('Location: index.php');
        exit;
    }
} 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Invoice</title>
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
        <h2>Add Invoice</h2>
        <form method="POST" action="add.php">
            <div class="form-group">
                <label for="client">Client:</label>
                <input type="text" id="client" name="client" required class="form-control" value="<?php echo $client ?? ''; ?>">
                <?php if (!empty($errors['client'])) : ?>
                    <div class="text-danger"><?php echo $errors['client']; ?></div>
                <?php endif; ?>
            </div> <br>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-control" value="<?php echo $email ?? ''; ?>">
                <?php if (!empty($errors['email'])) : ?>
                    <div class="text-danger"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div> <br>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required class="form-control" value="<?php echo $amount ?? ''; ?>">
                <?php if (!empty($errors['amount'])) : ?>
                    <div class="text-danger"><?php echo $errors['amount']; ?></div>
                <?php endif; ?>
            </div> <br>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required class="form-control">
                    <option value="" class="text-white">Select a Status</option>
                    <option value="draft" class="bg-secondary text-white"
                    <?php if(isset($status) && $status === 'draft') :?>
                        selected
                    <?php endif; ?>
                    >Draft</option>
                    <option value="pending" class="bg-warning"
                    <?php if(isset($status) && $status === 'pending') :?>
                        selected
                    <?php endif; ?>
                    >Pending</option>
                    <option value="paid" class="bg-success text-white"
                    <?php if(isset($status) && $status === 'paid') :?>
                        selected
                    <?php endif; ?>   
                    >Paid</option>
                </select>
                <?php if (!empty($errors['status'])) : ?>
                    <div class="text-danger"><?php echo $errors['status']; ?></div>
                <?php endif; ?>
            </div> <br>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
</body>
</html>
