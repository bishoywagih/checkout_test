<?php include 'layout/auth.php'; ?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h3>Please login so you can create blogs.</h3>
            <?php if(isset($_SESSION['errors'])) {
                ?>
                <div class="alert alert-danger">
                    <?php foreach ($_SESSION['errors'] as $error) {
                        if(is_array($error)){
                            foreach ($error as $message){
                                echo "<li>$message</li>";
                            }
                        }
                        else {
                            echo $error;
                        }
                    } ?>
                </div>
            <?php } ?>

            <form method="post" action="/auth/login" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <input type="file" name="image">
                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

