<?php

    require_once __DIR__ . '/../php/events.php';
    require_once __DIR__ . '/../php/sessions.php';
    require_once __DIR__ . '/../php/rooms.php';

    if(!isset($_GET['event'])) header('location: /events/');
    if(!isset($_GET['id'])) header('location: /events/');

    $eventData = get_event($_GET['event']);
    if(!$eventData) header('location: /events/');

    $sessionData = get_session($_GET['id']);
    if(!$sessionData) header('location: /events/');

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
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2"><?php echo $eventData['name']; ?></h1>
                </div>
                <span class="h6"><?php echo $eventData['date']; ?></span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Edit session</h2>
                </div>
            </div>

            <form class="needs-validation" method="POST">
            <div class="row">
                <?php
                    if(isset($_GET['error'])) echo '<p>'.$_GET['error'].'</p>';
                ?>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectType">Type</label>
                        <select class="form-control" id="selectType" name="type">
                            <?php if($sessionData['type'] == 'talk') { echo '<option value="talk" selected>Talk</option>'; } else { echo '<option value="talk">Talk</option>'; } ?>
                            <?php if($sessionData['type'] == 'workshop') { echo '<option value="workshop" selected>Workshop</option>'; } else { echo '<option value="workshop">Workshop</option>'; } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputTitle">Title</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control" id="inputTitle" name="title" placeholder="" value="<?php echo $sessionData['title']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputSpeaker">Speaker</label>
                        <input type="text" class="form-control" id="inputSpeaker" name="speaker" placeholder="" value="<?php echo $sessionData['speaker']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectRoom">Room</label>
              
                            <select class="form-control" id="selectRoom" required name="room">
                                <?php foreach(fetch_rooms($eventData['id']) as $room) : ?>
                                    <option value=<?php echo $room['id']; ?>><?php echo $room['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <div class="invalid-feedback">
                            Room is required.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCost">Cost</label>
                        <input type="number" class="form-control" id="inputCost" name="cost" placeholder="" value="<?php echo $sessionData['cost']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputStart">Start</label>
                        <input type="datetime-local"
                               class="form-control"
                               id="inputStart"
                               name="start"
                               required
                               placeholder="yyyy-mm-dd HH:MM"
                               value="<?php echo $sessionData['start']; ?>">
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label for="inputEnd">End</label>
                        <input type="datetime-local"
                                class="form-control"
                               id="inputEnd"
                               name="end"
                               required
                               placeholder="yyyy-mm-dd HH:MM"
                               value="<?php echo $sessionData['end']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="textareaDescription">Description</label>
                        <textarea class="form-control" id="textareaDescription" name="description" placeholder="" rows="5"><?php echo $sessionData['description']; ?></textarea>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit" name="edit_session">Save session</button>
                <a href="events/detail?event=<?php echo $eventData['id']; ?>" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>

</body>
</html>
