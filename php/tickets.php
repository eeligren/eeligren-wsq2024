<?php

if(isset($_POST['create_ticket'])) {
    $name = $_POST['name'];
    $cost = $_POST['cost'];
   
    $amount = $_POST['amount'];
    $valid_until = $_POST['valid_until'];

    $special_validity = "";
    $special_validity = $_POST['special_validity'];

    $eventId = $_GET['id'];


    if($special_validity == 'amount') {
        if(empty($amount)) return header('location: /tickets/create.php?id='.$eventId.'&error=Amount is invalid');

        $special_validity = '{"type": "amount", "amount": "'.$amount.'"}';
    }

    if($special_validity == 'date') {
        if(empty($valid_until)) return header('location: /tickets/create.php?id='.$eventId.'&error=Date is invalid');

        $special_validity = '{"type": "date", "date": "'.$valid_until.'"}';
    }
    

    $sql = "INSERT INTO event_tickets (event_id, name, cost, special_validity) VALUES ('$eventId', '$name', '$cost', '$special_validity')";
    if(mysqli_query($conn, $sql)) {
        return header('location: /events/detail.php?event='.$eventId.'&success=Ticket successfully created');
    } else {
        return header('location: /tickets/create.php?id='.$eventId.'&error=Error while creating event');
    }

}