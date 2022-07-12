<?php include 'layout/auth.php'; ?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h3>Register.</h3>
            <form method="post" action="/auth/register">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="name" name="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group mb-3">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-check  mb-3">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">remember me</label>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

