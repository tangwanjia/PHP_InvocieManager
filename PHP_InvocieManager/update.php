<?php

  require "data.php";

   //Fetching the invoice data for editing
   if (isset($_GET['number'])){
    $invoice = current(array_filter($invoices, function($invoice){
     return $invoice['number'] == $_GET['number'] ;
      
    }));
 }

  //allowe us to update and keep the data and back to the index page
  
  //update the data to invoices 
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
      $number = $_POST['number'];    
      $client = $_POST['client'];
      $email = $_POST['email'];
      $amount = $_POST['amount'];
      $status = $_POST['status'];
      $errors=[];
    

      //validate Client Name Field

    if (empty($client) || !preg_match('/^[A-Za-z\s]{1,255}$/', $client)){
      $errors['client'] = 'Client Name field must contain only letters and spaces and cannot exceed 255 characters.';
    }
    //validate Invoice Amount field, is_numeric: test the input should be number
    if(is_numeric($amount) || intval($amount) != $amount){
      $errors['amount'] = 'Invoice Amount must be an integer.';
    }
    //validate Client Email in the right format
    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors['email']='Client Emial field must be a properly formatted.';
    }
    //validate Invoice status field
    if($status !== 'draft' && $status !== 'pending' && $status !== 'paid'){
      $errors['status'] = 'Invoice Status must be either "draft", "pending", or "paid".';
    }
    //If there are no errors, update the invoice
    if(empty($errors)){
      //update the invoice dta here
      $_SESSION['invoices']=$invoices; //keep the updated data

      header("Location: index.php?id={$number}");
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Movie</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<style>
h2{
  text-align: center;
}

form-control{
  text-align: center;
}
</style>

<body>
  <main class="main">
    <?php require "header.php"; ?>
    <h2 class="form-title">Update Invoice</h2>
    <form class="form" method="post" >
      <input type="hidden" name="number" value= "<?php echo $invoice['number'] ;?>">
    
      <h6 class="subtitle">Invoice Number</h6>
      <input 
        type="text" 
        class="form-control
          <?php if(isset($errors['number'])): ?>is-invalid <?php endif;?>"
        name="number"  
        placeholder="Invoice Number"
        value="<?php echo $number ?? $invoice['number']; ?>">
      <div class="invalid-feedback">
        <?php if(isset($errors['number'])) : ?>
          <?php echo $errors ['number'] ; ?>
        <?php endif; ?>
      </div>

      <h6 class="subtitle">Invoice Amount</h6>
      <input 
        type="text" 
        class="form-control
          <?php if(isset($errors['amount'])) : ?>is-invalid<?php endif; ?>"
        name="amount"  
        placeholder="Amount"
        value="<?php echo $amount ?? $invoice['amount']; ?>">
      <div class="invalid-feedback">
        <?php if (isset($errors['amount'])) : ?>
          <?php echo $errors['amount']; ?>
        <?php endif; ?>
      </div>

      <h6 class="subtitle">Client Name</h6>
      <input 
        type="text" 
        class="form-control
          <?php if(isset($errors['client'])) : ?>is-invalid<?php endif; ?>"
        name="client"  
        placeholder="Client"
        value="<?php echo $client ?? $invoice['client']; ?>">
      <div class="invalid-feedback">
        <?php if (isset($errors['client'])) : ?>
          <?php echo $errors['client']; ?>
        <?php endif; ?>
      </div>

      <h6 class="subtitle">Client Email</h6>
      <input 
        type="text" 
        class="form-control
        <?php if(isset($errors['email'])):?>is-invalid<?php endif;?>"
        name="email"  
        placeholder="Email"
        value="<?php echo $invoice['email'] ?? $invoice['email']; ?>">
      <div class="invalid-feedback">
        <?php if(isset($errors['email'])):?>
          <?php echo $errors['email']; ?>
          <?php endif; ?>
      </div>

       
      <h6 class="subtitle">Invoice Status</h6>
      <select class="form-select"
        <?php if (isset($errors['status'])) :?>is-invalid<?php endif; ?>
      name="status">
      <option value="">Select a Status</option>
      <?php foreach ($statuses as $status) : ?>
      <option value="<?php echo $status; ?>"
      <?php if($status === $invoice['status']) :?> selected <?php endif ;?>>
      <?php echo $status; ?>
      </option>
      <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">
        <?php if(isset($errors['status'])) :?>
          <?php echo $errors['status']; ?>
        <?php endif; ?>
      </div></br>   
      
      <button type="submit" class="button">Update Movie</button>
      
      
    </form>
  </main>
</body>
</html>