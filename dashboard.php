<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$transactions = $conn->query(
    "SELECT * FROM transactions
     WHERE user_id = $user_id
     ORDER BY transaction_date DESC"
);

$income_query = $conn->query(
    "SELECT SUM(amount) as total_income
     FROM transactions
     WHERE type='income' AND user_id=$user_id"
);

$expense_query = $conn->query(
    "SELECT SUM(amount) as total_expense
     FROM transactions
     WHERE type='expense' AND user_id=$user_id"
);

$total_income = $income_query->fetch_assoc()['total_income'] ?? 0;
$total_expense = $expense_query->fetch_assoc()['total_expense'] ?? 0;
$balance = $total_income - $total_expense;
?>


<div class="row mb-4">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Total Income</h5>
            <h3 class="text-success">$<?php echo number_format($total_income, 2); ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Total Expenses</h5>
            <h3 class="text-danger">$<?php echo number_format($total_expense, 2); ?></h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Balance</h5>
            <h3 class="text-primary">$<?php echo number_format($balance, 2); ?></h3>
        </div>
    </div>
</div>

<a href="add_transaction.php" class="btn btn-dark mb-3">+ Add Transaction</a>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php while($row = $transactions->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo ucfirst($row['type']); ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>$<?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['transaction_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="delete_transaction.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
