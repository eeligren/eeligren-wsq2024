<?php

require_once __DIR__ . '/../php/db.php';
require_once __DIR__ . '/../php/auth.php';

if(isset($_POST['create_channel'])) {
    $name = $_POST['name'];
    $eventId = $_GET['id'];

    $sql = "INSERT INTO channels (event_id, name) VALUES ('$eventId', '$name')";
    if(mysqli_query($conn, $sql)) {
        header('location: /events/detail.php?event='.$eventId.'&success=Channel successfully created');
    } else {
        header('location: /channels/create.php?id='.$eventId.'&error=Error while creating event');
    }
}

function fetch_channels($eventId) {
    global $conn;    
    if($eventId) {
        $sql = "SELECT * FROM channels WHERE event_id='$eventId'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $channels = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $channels[] = $row;
            }
            return $channels;
        }
    }
    
    return [];
}


function get_rooms_amount($channelId) {
    global $conn;    
    if($channelId) {
        $sql = "SELECT * FROM rooms WHERE channel_id='$channelId'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            return mysqli_num_rows($result);
        }
    } else {
        return 0;
    }
    
}