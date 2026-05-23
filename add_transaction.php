<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_SESSION['user_id'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['transaction_date'];

    $sql = "INSERT INTO transactions
    (user_id, type, category, amount, description, transaction_date)
    VALUES
    ('$user_id', '$type', '$category', '$amount', '$description', '$date')";

    if ($conn->query($sql)) {
        header("Location: dashboard.php");
        exit();
    }
}

include 'includes/header.php';
?>

<div class="card shadow-sm">
    <div class="card-body">

        <h2 class="mb-4">Add Transaction</h2>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="transaction_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-dark">
                Save Transaction
            </button>

        </form>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
