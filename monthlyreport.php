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

$selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : date('Y-m');

$income_sql_month = "SELECT date, SUM(amount) as total_income FROM income WHERE DATE_FORMAT(date, '%Y-%m') = '$selected_month' GROUP BY date";
$expense_sql_month = "SELECT date, SUM(amount) as total_expense FROM expense WHERE DATE_FORMAT(date, '%Y-%m') = '$selected_month' GROUP BY date";

$income_result_month = $data->query($income_sql_month);
$expense_result_month = $data->query($expense_sql_month);

$income_data_month = [];
$expense_data_month = [];

while ($row = $income_result_month->fetch_assoc()) {
    $income_data_month[$row['date']] = $row['total_income'];
}

while ($row = $expense_result_month->fetch_assoc()) {
    $expense_data_month[$row['date']] = $row['total_expense'];
}
$report_data = [];
$dates = array_unique(array_merge(array_keys($income_data_month), array_keys($expense_data_month)));
sort($dates);

foreach ($dates as $date) {
    $total_income = isset($income_data_month[$date]) ? $income_data_month[$date] : 0;
    $total_expense = isset($expense_data_month[$date]) ? $expense_data_month[$date] : 0;
    $closing_balance = $total_income - $total_expense;
    
    $report_data[] = [
        'date' => $date,
        'total_income' => $total_income,
        'total_expense' => $total_expense,
        'closing_balance' => $closing_balance
    ];
}

$data->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Income and Expense Report</title>
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
    <h1>Monthly Income and expense Report</h1>

    <form method="POST" action="">
        <label for="month">Select Month:</label>
        <input type="month" id="month" name="selected_month" value="<?php echo $selected_month; ?>" required>
        <input type="submit" value="View Data">
    </form>

    <h2>Report for <?php echo date('F Y', strtotime($selected_month)); ?></h2>

    <table border="2px" style="width: 100%; text-align: center;">
        <tr>
            <th style="padding: 20px; font-size: larger;">Date</th>
            <th style="padding: 20px; font-size: larger;">Total Income</th>
            <th style="padding: 20px; font-size: larger;">Total Expense</th>
            <th style="padding: 20px; font-size: larger;">Closing Balance</th>
        </tr>
        <?php
        foreach ($report_data as $data) {
            echo "<tr>";
            echo "<td style='padding: 30px;'>{$data['date']}</td>";
            echo "<td style='padding: 30px;'>{$data['total_income']}</td>";
            echo "<td style='padding: 30px;'>{$data['total_expense']}</td>";
            echo "<td style='padding: 30px;'>{$data['closing_balance']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>
