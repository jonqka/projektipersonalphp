<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$id = (int)$_GET['id'];

$result = $conn->query("
    SELECT *
    FROM transactions
    WHERE id = $id
    AND user_id = ".$_SESSION['user_id']
);

$transaction = $result->fetch_assoc();

if (!$transaction) {
    die("Transaction not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $type = $_POST['type'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['transaction_date'];

    $sql = "
    UPDATE transactions
    SET
        type='$type',
        category='$category',
        amount='$amount',
        description='$description',
        transaction_date='$date'
    WHERE id=$id
    AND user_id=".$_SESSION['user_id'];

    if ($conn->query($sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo $conn->error;
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Transaction</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="income"
                            <?php if($transaction['type']=='income') echo 'selected'; ?>>
                            Income
                        </option>

                        <option value="expense"
                            <?php if($transaction['type']=='expense') echo 'selected'; ?>>
                            Expense
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input
                        type="text"
                        name="category"
                        class="form-control"
                        value="<?php echo htmlspecialchars($transaction['category']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input
                        type="number"
                        step="0.01"
                        name="amount"
                        class="form-control"
                        value="<?php echo $transaction['amount']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="3"><?php echo htmlspecialchars($transaction['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input
                        type="date"
                        name="transaction_date"
                        class="form-control"
                        value="<?php echo $transaction['transaction_date']; ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Update Transaction
                    </button>

                    <a href="dashboard.php" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>