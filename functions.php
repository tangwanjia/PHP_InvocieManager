<?php
require 'data.php';
function getInvoices($status){
    global $db;
    if($status === "all")
    {
        $sql = 'select * from invoices join statuses on invoices.status_id = statuses.id';
        $result = $db->prepare($sql);
        $result->execute();
        $invoices = $result->fetchAll();
    }
    else{
        $sql = 'select * from invoices join statuses on invoices.status_id = statuses.id where status = :status';
        $result = $db->prepare($sql);
        $result->execute([':status'=> $status]);
        $invoices = $result->fetchAll();
    }
    return $invoices;
}



?>