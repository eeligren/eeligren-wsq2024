<?php

require_once __DIR__ . '/../php/db.php';
require_once __DIR__ . '/../php/auth.php';

if(isset($_POST['create_session'])) {
    $type = $_POST['type'];
    $title = $_POST['title'];
    $speaker = $_POST['speaker'];
    $room = $_POST['room'];
    $cost = $_POST['cost'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $description = $_POST['description'];

    $eventId = $_GET['id'];

    //Checks if room is taken
    //$sql = "SELECT id FROM session WHERE room_id=$room AND ((start <= ? AND end >= ?) OR (start <= ? AND end >= ?))";
    
    $sql = "INSERT INTO sessions (room_id, title, description, speaker, start, end, type, cost) VALUES ('$room', '$title', $description, '$speaker', '$start', '$end', '$type', '$cost')";
    if(mysqli_query($conn, $sql)) {
        //return header('location: /events/detail.php?event='.$eventId.'&success=Session successfully created');
        return header('location: /sessions/create.php?id='.$eventId.'&error=OK');
    } else {
        return header('location: /sessions/create.php?id='.$eventId.'&error=Error while creating event'.mysqli_error($conn));
    }

}

function fetch_sessions($eventId) {
    global $conn;
    if($eventId) {
        $sql = "SELECT id FROM channels WHERE event_id=$eventId";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {         
            while ($row = mysqli_fetch_assoc($result)) {
                $channelId = $row['id'];
                $sql = "SELECT id FROM rooms WHERE channel_id=$channelId";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {         
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roomId = $row['id'];

                        $sql = "SELECT * FROM sessions WHERE room_id=$roomId";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) { 
                            $sessions = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sessions[] = $row;
                            }
                            return $sessions;
                        }
                        
                    }
                }

            }
        }
    }
    
    return [];
}


function get_sessions_amount($channelId) {

    global $conn;    
    if($channelId) {
        $sql = "SELECT * FROM rooms WHERE channel_id='$channelId'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $roomId = $row['id'];

            $sql = "SELECT * FROM sessions WHERE room_id=$roomId";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                return mysqli_num_rows($result);
            }
        }
    }

    return false;
}

function get_session($id) {
    global $conn;

    if($id) {
        $sql = "SELECT * FROM sessions WHERE id=$id LIMIT 1";
        if($result = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
    }

    return null;
}
