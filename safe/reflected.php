<!DOCTYPE html>
<html>

<head>
    <title>XSS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <nav class="navbar navbar-expand-sm bg-light justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="reflected.php">Reflected</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="stored.php">Stored</a>
            </li>
        </ul>
    </nav>

</head>

<body>
    <h1 align="center">Reflected</h1>
    <form method="GET">
        <p>Search for Users:</p></br>
        <input type="text" name="user_name">
        <input type="submit" class="btn btn-primary" value="Search">
    </form>


    <?php
    if(isset($_GET['user_name'])){
        $db = new SQLite3('users.db');

        echo "<div><h2>Search result for: ".htmlspecialchars($_GET["user_name"],ENT_QUOTES,'UTF-8')."</h2></div>";

        if($stmt = $db->prepare('SELECT * FROM users WHERE user_name LIKE :user_name'))
        {
            $user_name = SQLite3::escapeString(htmlspecialchars($_GET["user_name"],ENT_QUOTES,'UTF-8'));
            $stmt->bindValue(':user_name','%'.$user_name.'%');
            $res = $stmt->execute();
            while ($row = $res->fetchArray()) {
                echo htmlspecialchars("{$row['user_name']}",ENT_QUOTES,'UTF-8');
                echo '<br>';
            }
        }
    }

    ?>

</body>

</html>
