<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <style>
        #ml{
            margin-left:300px;
        }
    </style>
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
    <br><br><br> <br><br><br>
    <h1 id="ml">
        Welcome to my Petty Book
    </h1>
</body>
</html>
