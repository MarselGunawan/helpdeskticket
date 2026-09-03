<?php

require_once "config/database.php";

$errors = [];

$subject = "";
$category = "";
$description = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $subject = trim($_POST["subject"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $description = trim($_POST["description"] ?? "");


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


    // ==============================
    // Insert
    // ==============================

    if (empty($errors)) {

        $sql = "INSERT INTO tickets
                (subject, category, description)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sss",
            $subject,
            $category,
            $description
        );

        if ($stmt->execute()) {

            header("Location: index.php");

            exit;

        } else {

            $errors[] = "Failed to create ticket.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Ticket</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container small-container">

    <div class="form-card">

        <div class="form-header">

            <h1>Create Ticket</h1>

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
                    placeholder="Enter ticket subject"
                >

            </div>


            <!-- Category -->

            <div class="form-group">

                <label>
                    Category <span>*</span>
                </label>

                <select name="category">

                    <option value="">
                        -- Select Category --
                    </option>

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
                    placeholder="Describe the problem..."
                ><?php echo htmlspecialchars($description); ?></textarea>

            </div>


            <!-- Status Information -->

            <div class="status-info">

                New tickets will automatically be created with status:

                <strong>Open</strong>

            </div>


            <div class="form-actions">

                <a href="index.php" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Submit Ticket
                </button>

            </div>

        </form>

    </div>

</div>

<script src="js/script.js"></script>

</body>

</html>