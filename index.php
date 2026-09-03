<?php

require_once "config/database.php";

// Search berdasarkan subject
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Query ticket
if ($search !== "") {
    $sql = "SELECT * FROM tickets 
            WHERE subject LIKE ? 
            ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);

    $searchParam = "%" . $search . "%";
    $stmt->bind_param("s", $searchParam);

    $stmt->execute();

    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM tickets ORDER BY created_at DESC";
    $result = $conn->query($sql);
}

// Total ticket
$totalQuery = "SELECT COUNT(*) AS total FROM tickets";
$totalResult = $conn->query($totalQuery);
$totalData = $totalResult->fetch_assoc();
$totalTickets = $totalData['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Helpdesk Ticket System</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <!-- Header -->
        <div class="header">

            <div>
                <h1>Helpdesk Ticket System</h1>
                <p>Manage employee helpdesk tickets</p>
            </div>

            <a href="create.php" class="btn btn-primary">
                + Create Ticket
            </a>

        </div>


        <!-- Summary -->
        <div class="summary">

            <div class="summary-card">
                <span class="summary-title">Total Tickets</span>
                <strong><?php echo $totalTickets; ?></strong>
            </div>

        </div>


        <!-- Search -->
        <div class="search-section">

            <form method="GET" action="index.php">

                <div class="search-box">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search ticket by subject..."
                        value="<?php echo htmlspecialchars($search); ?>"
                    >

                    <button type="submit" class="btn btn-search">
                        Search
                    </button>

                    <?php if ($search !== ""): ?>

                        <a href="index.php" class="btn btn-secondary">
                            Reset
                        </a>

                    <?php endif; ?>

                </div>

            </form>

        </div>


        <!-- Ticket Table -->
        <div class="table-container">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($ticket = $result->fetch_assoc()): ?>

                            <tr>

                                <!-- ID -->
                                <td>
                                    <?php echo $ticket['id']; ?>
                                </td>


                                <!-- Subject -->
                                <td>
                                    <strong>
                                        <?php echo htmlspecialchars($ticket['subject']); ?>
                                    </strong>
                                </td>


                                <!-- Category -->
                                <td>
                                    <?php echo htmlspecialchars($ticket['category']); ?>
                                </td>


                                <!-- Status -->
                                <td>

                                    <?php

                                    $statusClass = '';

                                    switch ($ticket['status']) {

                                        case 'Open':
                                            $statusClass = 'status-open';
                                            break;

                                        case 'In Progress':
                                            $statusClass = 'status-progress';
                                            break;

                                        case 'Closed':
                                            $statusClass = 'status-closed';
                                            break;
                                    }

                                    ?>

                                    <span class="status <?php echo $statusClass; ?>">

                                        <?php echo htmlspecialchars($ticket['status']); ?>

                                    </span>

                                </td>


                                <!-- Created Date -->
                                <td>
                                    <?php
                                    echo date(
                                        'd M Y, H:i',
                                        strtotime($ticket['created_at'])
                                    );
                                    ?>
                                </td>


                                <!-- Action -->
                                <td>

                                    <div class="actions">

                                        <a
                                            href="edit.php?id=<?php echo $ticket['id']; ?>"
                                            class="btn btn-edit"
                                        >
                                            Edit
                                        </a>


                                        <a
                                            href="delete.php?id=<?php echo $ticket['id']; ?>"
                                            class="btn btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this ticket?');"
                                        >
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6" class="empty">

                                <?php if ($search !== ""): ?>

                                    No tickets found for:
                                    <strong>
                                        <?php echo htmlspecialchars($search); ?>
                                    </strong>

                                <?php else: ?>

                                    No tickets available.

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>