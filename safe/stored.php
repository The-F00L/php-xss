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
    <h1 align="center">Stored XSS</h1>
    <form method="POST">
        <p>User:</p>
        <input type="text" name="user_name">
        <p>Comment:</p>
        <input type="text" name="comment">
        <input type="submit" class="btn btn-primary" value="Add">
    </form>


    <?php

    $db = new SQLite3('users.db');
    if(isset($_POST['user_name'])){

        if($stmt = $db->prepare('INSERT INTO users(user_name, comment) VALUES (:user_name, :comment)'))
        {
            $stmt->bindValue(':user_name',htmlspecialchars($_POST["user_name"],ENT_QUOTES,'UTF-8'));
            $stmt->bindValue(':comment',htmlspecialchars($_POST["comment"],ENT_QUOTES,'UTF-8'));
            $res = $stmt->execute();
        }
    }

    $res = $db->query('SELECT * FROM users');
    echo "<br>User | Comment<br>";
    while ($row = $res->fetchArray()) {
        echo htmlspecialchars("{$row['user_name']} {$row['comment']}",ENT_QUOTES,'UTF-8');
        echo "<br>";
    }

    ?>


</body>

</html>