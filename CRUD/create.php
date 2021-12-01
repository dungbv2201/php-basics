<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .required{
            color: red;
        }
        .avatar{
            width: 200px;
            height: 200px;
            margin: 15px 0;
            margin-bottom: 30px;
        }
        .avatar img{
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-5">
            <h2 class="text-success mb-3">Create user</h2>
            <form action="handlers/store.php" method="post">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First name <span class="required">*</span></label>
                    <input
                        type="text"
                        class="form-control"
                        id="firstName"
                        name="fist_name"
                    >
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last name <span class="required">*</span></label>
                    <input
                        type="text"
                        class="form-control"
                        id="lastName"
                        name="last_name"
                    >
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address <span class="required">*</span></label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="required">*</span></label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                    >
                </div>
                <div class="mb-3">
                    <label for="dateOfBirth" class="form-label">Date of birth</label>
                    <input
                        type="date"
                        class="form-control"
                        id="dateOfBirth"
                        name="date_of_birth"
                    >
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input
                        type="file"
                        class="form-control"
                        id="avatar"
                        name="avatar"
                    >
                    <div class="avatar">
                        <img src="public/images/avatar.jpg" alt="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea
                       class="form-control" id="address"
                       name="address"
                       rows="5"
                    >
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    function previewAvatar(){
	    const avatarInput = document.querySelector('#avatar');
	    avatarInput.addEventListener('change', function(e){
		    const { files } = e.target;
		    const preview = document.querySelector('img');
		    const reader = new FileReader();
		    if (files[0]) {
			    reader.readAsDataURL(files[0]);
		    }
		    reader.addEventListener("load", function () {
			    preview.src = reader.result;
		    }, false);
	    })
    }
    previewAvatar();
</script>
</body>
</html>