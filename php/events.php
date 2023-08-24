<?php

require_once __DIR__ . '/../php/db.php';
require_once __DIR__ . '/../php/auth.php';

if(isset($_POST['create'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $date = $_POST['date'];

    if(!preg_match("/^[a-z0-9-]+$/", $slug) == 1) {
        return header('location: /events/create.php?error=Slug must not be empty and only contain a-z, 0-9 and "-".');
    }

    $loggedUserId = check_login()['id'];
    
    $sql = "SELECT * FROM events WHERE slug='$slug'";
    $result = mysqli_query($conn, $sql);

    if(!mysqli_num_rows($result) > 0) {
        $sql = "INSERT INTO events (organizer_id, name, slug, date) VALUES ('$loggedUserId', '$name', '$slug', '$date')";
        if(mysqli_query($conn, $sql)) {
            header('location: /events?success=Event successfully updated');
        } else {
            return header('location: /events/create.php?error=Error while creating event');
        }
    } else {
        return header('location: /events/create.php?error=Slug is already used');
    }
}

if(isset($_POST['edit'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $date = $_POST['date'];

    if(!preg_match("/^[a-z0-9-]+$/", $slug) == 1) {
        return header('location: /events/edit.php?id='.$_GET['id'].'&error=Slug must not be empty and only contain a-z, 0-9 and "-".');
    }

    $loggedUserId = check_login()['id'];
    
    $sql = "SELECT * FROM events WHERE slug='$slug'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        if(mysqli_fetch_assoc($result)['slug'] !== $slug) {
            return header('location: /events/edit.php?id='.$_GET['id'].'&error=Slug is already used');
        }

        $id = $_GET['id'];

        $sql = "UPDATE events SET name='$name', slug='$slug', date='$date' WHERE id=$id";
        if(mysqli_query($conn, $sql)) {
            header('location: /events/detail.php?event='.$_GET['id'].'&event='.$id.'&success=Event successfully updated');
        } else {
            return header('location: /events/edit.php?id='.$_GET['id'].'&error=Error while creating event');
        }
    }
}


function get_event($id) {
    global $conn;

    if($id) {
        $sql = "SELECT * FROM events WHERE id=$id LIMIT 1";
        if($result = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
    }

    return null;
}

function fetch_events($user) {
    global $conn;    
    if($user) {
        $userId = $user['id'];

        $sql = "SELECT * FROM events WHERE organizer_id='$userId' ORDER BY date ASC";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $events = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $events[] = $row;
            }
            return $events;
        }
    }
    return [];
}

function get_registered($eventId) {
    global $conn;  

    if($eventId) {
        $sql = "SELECT * FROM event_tickets WHERE event_id='$eventId'";
        $result = mysqli_query($conn, $sql);
            
        return mysqli_num_rows($result);
    }
}

function fetch_events_tickets($eventId) {
    global $conn;    
    if($eventId) {
        $sql = "SELECT * FROM event_tickets WHERE event_id='$eventId'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $tickets = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $tickets[] = $row;
            }
            return $tickets;
        }
    }

    return [];
}

function get_ticket_specials($ticketId) {
    global $conn;    
    if($ticketId) {
        $sql = "SELECT special_validity FROM event_tickets WHERE id='$ticketId' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $data = json_decode($row['special_validity'], true);

            if($data && isset($data['type'])) {
                if($data['type'] == 'date') {
                    return 'Available until ' . $data['date'];
                }

                if($data['type'] == 'amount') {
                    return $data['amount'] . ' tickets available';
                }
            }
        }
    } else {
        return null;
    }
}
