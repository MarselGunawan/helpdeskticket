<?php

require_once "config/database.php";


// ==============================
// Get ID
// ==============================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {

    header("Location: index.php");

    exit;

}


// ==============================
// Get Ticket
// ==============================

$sql = "SELECT * FROM tickets WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$ticket = $result->fetch_assoc();

if (!$ticket) {

    header("Location: index.php");

    exit;

}


// ==============================
// Variables
// ==============================

$errors = [];

$subject = $ticket["subject"];
$category = $ticket["category"];
$description = $ticket["description"];
$status = $ticket["status"];


// ==============================
// Update
// ==============================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $subject = trim($_POST["subject"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = trim($_POST["status"] ?? "");


    // ==============================
    // Validation
    // ==============================

    if ($subject === "") {
        $errors[] = "Subject is required.";
    }

    if ($category === "") {
        $errors[] = "Category is required.";
    }

    if ($description === "") {
        $errors[] = "Description is required.";
    }

    $allowedStatus = [
        "Open",
        "In Progress",
        "Closed"
    ];

    if (!in_array($status, $allowedStatus)) {
        $errors[] = "Invalid status.";
    }


    // ==============================
    // Update Database
    // ==============================

    if (empty($errors)) {

        $sql = "UPDATE tickets
                SET subject = ?,
                    category = ?,
                    description = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssssi",
            $subject,
            $category,
            $description,
            $status,
            $id
        );

        if ($stmt->execute()) {

            header("Location: index.php");

            exit;

        } else {

            $errors[] = "Failed to update ticket.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Ticket</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container small-container">

    <div class="form-card">

        <div class="form-header">

            <h1>Edit Ticket</h1>

            <a href="index.php" class="btn btn-secondary">
                Back
            </a>

        </div>


        <!-- Error -->

        <?php if (!empty($errors)): ?>

            <div class="alert alert-error">

                <ul>

                    <?php foreach ($errors as $error): ?>

                        <li>
                            <?php echo htmlspecialchars($error); ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>


        <form method="POST">


            <!-- Subject -->

            <div class="form-group">

                <label>
                    Subject <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject"
                    value="<?php echo htmlspecialchars($subject); ?>"
                >

            </div>


            <!-- Category -->

            <div class="form-group">

                <label>
                    Category <span>*</span>
                </label>

                <select name="category">

                    <option value="Hardware"
                        <?php echo ($category === "Hardware") ? "selected" : ""; ?>>
                        Hardware
                    </option>

                    <option value="Software"
                        <?php echo ($category === "Software") ? "selected" : ""; ?>>
                        Software
                    </option>

                    <option value="Network"
                        <?php echo ($category === "Network") ? "selected" : ""; ?>>
                        Network
                    </option>

                    <option value="Others"
                        <?php echo ($category === "Others") ? "selected" : ""; ?>>
                        Others
                    </option>

                </select>

            </div>


            <!-- Description -->

            <div class="form-group">

                <label>
                    Description <span>*</span>
                </label>

                <textarea
                    name="description"
                    rows="6"
                ><?php echo htmlspecialchars($description); ?></textarea>

            </div>


            <!-- Status -->

            <div class="form-group">

                <label>
                    Status
                </label>

                <select name="status">

                    <option value="Open"
                        <?php echo ($status === "Open") ? "selected" : ""; ?>>
                        Open
                    </option>

                    <option value="In Progress"
                        <?php echo ($status === "In Progress") ? "selected" : ""; ?>>
                        In Progress
                    </option>

                    <option value="Closed"
                        <?php echo ($status === "Closed") ? "selected" : ""; ?>>
                        Closed
                    </option>

                </select>

            </div>


            <!-- Buttons -->

            <div class="form-actions">

                <a href="index.php" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Ticket
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>