<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="events/">Manage Events</a></li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span><?php echo $eventData['name']; ?></span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="events/detail.php">Overview</a></li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Reports</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item"><a class="nav-link" href="reports/index.php?id=<?php echo $eventData['id']; ?>">Room capacity</a></li>
        </ul>
    </div>
</nav>