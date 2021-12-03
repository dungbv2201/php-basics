<?php
session_start();
require_once __DIR__ . '/handlers/connectDb.php';
define("PER_PAGE", 5);

$pdo = connectDb();
$name = $_GET['name'] ?? '';
$searchName = '%%';
if($name){
	$searchName = '%'.$name.'%';
}
$page = $_GET["page"] ?? 1;
$query = "SELECT count(id) AS total FROM users";
$totalRecord = findOne($pdo,$query)->total;
$totalPage = ceil($totalRecord/PER_PAGE);
$offset = ($page -1) * PER_PAGE + 1;
$users = paginate($pdo, $searchName, $offset, PER_PAGE);

function paginate($pdo, $searchName, $offset, $limit){
	$query = "SELECT * FROM users WHERE first_name LIKE :name LIMIT $limit OFFSET $offset";
	$statement = $pdo->prepare($query);
	$statement->execute(["name" => $searchName]);
	return $statement->fetchAll(\PDO::FETCH_OBJ);
}
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
        .alert{
			display: block;
			opacity: 1;
			transition: 03s;
        }
    </style>
</head>
<body>
    <section class="user-list">
        <div class="container">
			<div class="row justify-content-end">
				<?php if(isset($_SESSION['created'])): ?>
					<div class="alert alert-success mt-2 col-md-3" role="alert">
						Created user successfully!
					</div>
				<?php endif; ?>
				<?php if(isset($_SESSION['deleteSuccess'])): ?>
					<div class="alert alert-success mt-2 col-md-3" role="alert">
						<?php echo $_SESSION['deleteSuccess']?>
					</div>
				<?php endif; ?>
				<?php if(isset($_SESSION['errorDelete'])): ?>
					<div class="alert alert-danger mt-2 col-md-3" role="alert">
						<?php echo $_SESSION['errorDelete']?>
					</div>
				<?php endif; ?>
			</div>
            <div class="row justify-content-center">
                <div class="col-12 d-flex justify-content-between mt-2">
                    <h2 class="col">User list</h2>
                    <div class="col">
                        <a href="create.php" class="btn btn-primary mr-0" style="float: right">Create</a>
                    </div>
                </div>
				<div>
					<form class="mb-3 d-flex col-6 justify-content-between">
						<div class="col-sm-9">
							<input type="text"
								   name="name"
								   value="<?= $name ?>"
								   class="form-control" id="staticEmail">
						</div>
						<button class="col-sm-2 btn btn-success ml-4">Search</button>
					</form>
				</div>
                <table class="table table-striped table-hover col-md-8">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Email</th>
                        <th scope="col" width="200px">Date of birth</th>
                        <th scope="col" width="150px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($users)):?>
                        <tr>
                            <td scope="row" colspan="4" class="text-center">Empty data</td>
                        </tr>
                    <?php else:
						foreach ($users as $key => $user):
					?>
                        <tr>
                            <th scope="row">
								<?= $user->id ?>
							</th>
                            <td><?= $user->first_name ?></td>
                            <td><?= $user->last_name ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->date_of_birth ?></td>
                            <td>
								<a href="<?= 'show.php?id='.$user->id ?>" class="btn btn-warning mr-2">Edit</a>
								<form action="handlers/delete.php" method="post"
									  class="form-delete"
									  style="display: inline-block">
									<input type="hidden" name="id" value="<?= $user->id ?>">
									<button class="btn btn-danger btn-delete">Delete</button>
								</form>
							</td>
                        </tr>
                    <?php
                    	endforeach;
					endif;
					?>
                    </tbody>
                </table>
				<?php if($totalPage > 1):?>
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<?php if($page > 1):?>
								<li class="page-item">
									<a class="page-link" href="index.php?page=<?=$key -1?>">Previous</a>
								</li>
							<?php endif ?>
							<?php for($i=1;$i<=$totalPage;$i++): ?>
								<li class="page-item <?php echo $page == $i?'active':''?>">
									<a class="page-link" href="index.php?page=<?=$i?>">
										<?=$i?>
									</a>
								</li>
							<?php endfor?>
							<?php if($page >=1 && $page < $totalPage):?>
								<li class="page-item">
									<a class="page-link" href="index.php?page=<?=$key +1?>">Next</a>
								</li>
							<?php endif ?>
						</ul>
					</nav>
				<?php endif; ?>
            </div>
        </div>
    </section>
	<script>
		document.addEventListener('DOMContentLoaded',function(){
			const alertEl = document.querySelector('.alert')
			if(alertEl){
				setTimeout(()=>{
					alertEl.remove();
				},3500)
			}

			function deleteUser(){
				const els = document.querySelectorAll('.form-delete')
				for(el of els){
					el.addEventListener('click',function(){
						const result = confirm('Are you sure want to delete user?');
						if(result){
							this.submit();
						}
					})
				}
			}
			deleteUser()
		})
	</script>
</body>
</html>
<?php
	unset($_SESSION['created']);
	unset($_SESSION['errorDelete']);
	unset($_SESSION['deleteSuccess']);
?>
