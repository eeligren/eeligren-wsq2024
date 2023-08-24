<?php
    require_once __DIR__ . '/../php/db.php';
    require_once __DIR__ . '/../php/events.php';
    require_once __DIR__ . '/../php/channels.php';
    require_once __DIR__ . '/../php/rooms.php';
    require_once __DIR__ . '/../php/sessions.php';

    header('Content-Type: application/json');

    $attendees = [];
    $capacity = [];
    $rooms = [];

    $data['attendees'] = $attendees;
    $data['capacity'] = $capacity;
    $data['rooms'] = $rooms;

    echo json_encode($data);