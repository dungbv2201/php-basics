<?php
    require_once __DIR__ . '/handlers/connectDb.php';
    $pdo = connectDb();
    $query = "SELECT * FROM users";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll(\PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .user-list{

        }
    </style>
</head>
<body>
    <section class="user-list mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 d-flex justify-content-between">
                    <h2 class="col">User list</h2>
                    <div class="col">
                        <a href="create.php" class="btn btn-success mr-0" style="float: right">Create</a>
                    </div>
                </div>
                <table class="table table-striped table-hover col-md-8">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($users)):?>
                        <tr>
                            <td scope="row" colspan="4" class="text-center">Empty data</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th scope="row" colspan="4">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>