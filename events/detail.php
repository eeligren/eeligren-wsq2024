<?php

require_once __DIR__ . '/../php/events.php';
require_once __DIR__ . '/../php/channels.php';
require_once __DIR__ . '/../php/rooms.php';
require_once __DIR__ . '/../php/sessions.php';

if(!isset($_GET['event'])) header('location: /events/');

$eventData = get_event($_GET['event']);
if(!$eventData) header('location: /events/');

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Backend</title>

    <base href="../">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
<?php include __DIR__ . '/../components/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../components/sidebar.php'; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2"><?php echo $eventData['name']; ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="events/edit.php?id=<?php echo $eventData['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit event</a>
                        </div>
                    </div>
                </div>
                <span class="h6"><?php echo $eventData['date']; ?></span>
            </div>

            <p><?php if(isset($_GET['success'])) echo $_GET['success']; ?></p>

            <!-- Tickets -->
            <div id="tickets" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tickets</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="tickets/create.php?id=<?php echo $eventData['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                Create new ticket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tickets">
                <?php 
                $tickets = fetch_events_tickets($eventData['id']);
                foreach($tickets as $ticket): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $ticket['name']; ?></h5>
                                <p class="card-text"><?php echo $ticket['cost']; ?>-</p>
                                <p class="card-text"><?php echo get_ticket_specials($ticket['id']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Sessions -->
            <div id="sessions" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Sessions</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="sessions/create.php?id=<?php echo $eventData['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                Create new session
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive sessions">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th class="w-100">Title</th>
                        <th>Speaker</th>
                        <th>Channel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sessions = fetch_sessions($eventData['id']);
                    foreach($sessions as $session): ?>
                        <tr>
                            <td class="text-nowrap"><?php $date = date_create($session['start']); echo date_format($date,"H:i"); ?> - <?php $date = date_create($session['end']); echo date_format($date,"H:i"); ?></td>
                            <td>Talk</td>
                            <td><a href="sessions/edit.php?event=<?php echo $eventData['id']; ?>&id=<?php echo $session['id']; ?>"><?php echo $session['title']; ?></a></td>
                            <td class="text-nowrap"><?php echo $session['speaker']; ?></td>
                            <td class="text-nowrap"><?php echo get_room($session['room_id'])['name']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Channels -->
            <div id="channels" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Channels</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="channels/create.php?id=<?php echo $eventData['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                Create new channel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row channels">
                <?php 
                $channels = fetch_channels($eventData['id']);
                foreach($channels as $channel): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $channel['name']; ?></h5>
                                <p class="card-text"><?php echo get_sessions_amount($channel['id']) ?> sessions, <?php echo get_rooms_amount($channel['id']) ?> room</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Rooms -->
            <div id="rooms" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Rooms</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="rooms/create.php?id=<?php echo $eventData['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                Create new room
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rooms">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $channels = fetch_channels($eventData['id']);

                    foreach($channels as $channel) {
                        $rooms = get_room_by_channel($channel['id']);
                        foreach($rooms as $r) {
                            echo '<tr>
                            <td>'.$r['name'].'</td>
                            <td>'.$r['capacity'].'</td>
                        </tr>';
                        }
                        
                    }

                    ?>
                        
     
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

</body>
</html>
