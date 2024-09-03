<?php
error_reporting(0);
$host = "localhost";
$user = "root";
$password = "";
$db = "pbook";
session_start();

$data = new mysqli($host, $user, $password, $db);

if ($data->connect_error) {
    die("Connection failed: " . $data->connect_error);
}

$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');

$income_sql = "SELECT * FROM income WHERE date = '$selected_date'";
$expense_sql = "SELECT * FROM expense WHERE date = '$selected_date'";

$income_result = $data->query($income_sql);
$expense_result = $data->query($expense_sql);

$income_data = [];
$expense_data = [];

while ($row = $income_result->fetch_assoc()) {
    $income_data[] = $row;
}

while ($row = $expense_result->fetch_assoc()) {
    $expense_data[] = $row;
}

$data->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expense Table</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="nav1">
        <label class="logo">Transaction-Hub</label>
        <ul>
            <li><a href="index.php" class="btn btn-primary">Logout</a></li>
        </ul>
    </nav>
    <nav class="nav2">
        <ul>
            <li><a href="index.php" id="admin">Main Page</a></li>
            <li><a href="income.php">Add Income</a></li>
            <li><a href="expense.php">Add Expenses</a></li>
            <li><a href="view_data.php">View Day Data</a></li>
            <li><a href="monthlyreport.php">View Month Data</a></li>
        </ul>
    </nav>
    <div class="content">
    <h1>Income and Expense Table</h1>

    <form method="POST" action="">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="selected_date" value="<?php echo $selected_date; ?>" required>
        <input type="submit" value="View Data">
    </form>

    <table border="2px" style="width: 100%; text-align: center;">
        <tr>
            <th style="padding: 20px; font-size: larger;">Income</th>
            <th style="padding: 20px; font-size: larger;">Amount</th>
            <th style="padding: 20px; font-size: larger;">Description</th>
            <th style="padding: 20px; font-size: larger;">Expense</th>
            <th style="padding: 20px; font-size: larger;">Amount</th>
            <th style="padding: 20px; font-size: larger;">Description</th>
        </tr>
        <?php
        $max_rows = max(count($income_data), count($expense_data));
        for ($i = 0; $i < $max_rows; $i++) {
            echo "<tr>";
            if (isset($income_data[$i])) {
                echo "<td style='padding: 30px;'>{$income_data[$i]['head']}</td>";
                echo "<td style='padding: 30px;'>{$income_data[$i]['amount']}</td>";
                echo "<td style='padding: 30px;'>{$income_data[$i]['des']}</td>";
            } else {
                echo "<td style='padding: 30px;'></td><td style='padding: 30px;'></td><td style='padding: 30px;'></td>";
            }

            if (isset($expense_data[$i])) {
                echo "<td style='padding: 30px;'>{$expense_data[$i]['exp']}</td>";
                echo "<td style='padding: 30px;'>{$expense_data[$i]['amount']}</td>";
                echo "<td style='padding: 30px;'>{$expense_data[$i]['des']}</td>";
            } else {
                echo "<td style='padding: 30px;'></td><td style='padding: 30px;'></td><td style='padding: 30px;'></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
    <?php

$incomeamount = 0;
foreach ($income_data as $income) {
    $incomeamount += $income['amount'];
}
echo "Total Income Amount: $incomeamount";
?>
<br>
<br>
<?php

$expenseamount = 0;
foreach ($expense_data as $expense) {
    $expenseamount += $expense['amount'];
}
echo "Total Expense Amount: $expenseamount";
?>
<br>
<br>
<?php

$closing_balance = $incomeamount - $expenseamount;
echo "Closing Balance: $closing_balance";
?>
</div>
</body>
</html>
