<?php
error_reporting(E_ALL);
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "pbook";

$data = new mysqli($host, $user, $password, $db);

if ($data->connect_error) {
    die("Connection failed: " . $data->connect_error);
}

if (isset($_POST['add_expense'])) {
    $exp = $data->real_escape_string($_POST['exp']);
    $amount = $data->real_escape_string($_POST['amount']);
    $des = $data->real_escape_string($_POST['des']);
    $date = $data->real_escape_string($_POST['date']);

    $allowed_descriptions = [
        'Rent', 'Bill', 'EMI', 'Tax', 'Fees', 'Interest',
        'Salary', 'Stationary', 'Printing', 'ADs'
    ];
    if (!in_array($des, $allowed_descriptions)) {
        echo "Invalid description.";
        exit();
    }

    $stmt = $data->prepare("INSERT INTO expense (exp, amount, des, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $exp, $amount, $des, $date);

    if ($stmt->execute()) {
        $message = "Data uploaded";
    } else {
        $message = "Data not uploaded: " . $stmt->error;
    }

    $stmt->close();
    $data->close();

    echo "<script>
        window.onload = function() {
            alert('$message');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "';
        }
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
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
    <h1>Expense Table</h1>
    <div class="content">
        <h1>Add Expense</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
                <label for="exp">Expense Head</label>
                <input type="text" name="exp" id="exp" required>
            </div>
            <div>
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" required>
            </div>
            <div>
                <label for="des">Description</label>
                <select name="des" id="des" required>
                    <option value="">Select Description</option>
                    <option value="Rent">Rent</option>
                    <option value="Bill">Bill</option>
                    <option value="EMI">EMI</option>
                    <option value="Tax">Tax</option>
                    <option value="Fees">Fees</option>
                    <option value="Interest">Interest</option>
                    <option value="Salary">Salary</option>
                    <option value="Stationary">Stationary</option>
                    <option value="Printing">Printing</option>
                    <option value="ADs">ADs</option>
                </select>
            </div>
            <div>
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div>
                <input type="submit" name="add_expense" value="Add Expense">
            </div>
        </form>
    </div>
</body>
</html>
