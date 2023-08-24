<?php

require_once __DIR__ . '/../php/db.php';
require_once __DIR__ . '/../php/auth.php';

if(isset($_POST['create_room'])) {
    $name = $_POST['name'];
    $channel = $_POST['channel'];
    $capacity = $_POST['capacity'];


    $sql = "INSERT INTO rooms (channel_id, name, capacity) VALUES ($channel, '$name', '$capacity')";
    if(mysqli_query($conn, $sql)) {
        header('location: /events/detail.php?event='.$_GET['id'].'&success=Room successfully created');
    } else {
        return header('location: /rooms/create.php?id='.$_GET['id'].'&error=Error while creating room'.mysqli_error($conn));
    }
}

function fetch_rooms($eventId) {
    global $conn;
    if($eventId) {
        $sql = "SELECT id FROM channels WHERE event_id=$eventId";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $channelId = $row['id'];

            $sql = "SELECT * FROM rooms WHERE channel_id=$channelId";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0) {
                $rooms = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $rooms[] = $row;
                }
                return $rooms;
            }
        }
    }

    return [];
}

function get_room($roomId) {
    global $conn;

    if($roomId) {
        $sql = "SELECT * FROM rooms WHERE id=$roomId";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        }
    }

    return false;
}

function get_room_by_channel($channelId) {
    global $conn;
    if($channelId) {
        $sql = "SELECT * FROM rooms WHERE channel_id=$channelId";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $rooms = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $rooms[] = $row;
            }
            return $rooms;
        }
    }

    return [];
}