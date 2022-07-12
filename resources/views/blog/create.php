<div class="container">
    <div class="mt-2">
        <form action="/blog" method="post" enctype="multipart/form-data">
            <input type="file" name="image">
            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
            <button type="submit">Create</button>
        </form>
    </div>
</div>

