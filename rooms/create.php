<?php

    require_once __DIR__ . '/../php/events.php';
    require_once __DIR__ . '/../php/sessions.php';
    require_once __DIR__ . '/../php/channels.php';
    require_once __DIR__ . '/../php/rooms.php';

    if(!isset($_GET['id'])) header('location: /events/');

    $eventData = get_event($_GET['id']);
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
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2"><?php echo $eventData['name']; ?></h1>
                </div>
                <span class="h6"><?php echo $eventData['date']; ?></span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Create new room</h2>
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
                        <label for="inputName">Name</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control" id="inputName" name="name" required placeholder="" value="">

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectChannel">Channel</label>
                        <select class="form-control" id="selectChannel" required name="channel">
                            <?php foreach(fetch_channels($eventData['id']) as $channel) : ?>
                                <option value=<?php echo $channel['id']; ?>><?php echo $channel['name']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCapacity">Capacity</label>
                        <input type="number" class="form-control" id="inputCapacity" required name="capacity" placeholder="" value="">
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit" name="create_room">Save room</button>
                <a href="events/detail.php?event=<?php echo $eventData['id']; ?>" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>

</body>
</html>
