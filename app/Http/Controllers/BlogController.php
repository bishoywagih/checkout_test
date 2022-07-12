<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthMiddleware;
use App\Models\Blog;
use App\Models\User;
use PDO;

class BlogController extends Controller
{
    protected Blog $blog;

    public function __construct()
    {
        parent::__construct();
        (new AuthMiddleware())->handle([
            'blog',
            'blog/create'
        ]);
        $this->blog = new Blog();
    }

    public function index()
    {
        $perPage = 1;
        $rowsCount = $this->blog->count();
        $total_pages = ceil($rowsCount / $perPage);
        $page = $_GET['page'] ?? 1;
        $starting_limit = ($page - 1) * $perPage;
        $sql = "SELECT * FROM blogs ORDER BY id DESC LIMIT $starting_limit , $perPage";
        $statement = $this->db->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, Blog::class);
        $statement->execute();
        $blogs = $statement->fetchAll();

        return view('blog/index', compact('blogs'));
    }

    public function create()
    {
        return view('blog/create');
    }

    public function show($id)
    {
        dd($id);
        return view('blog/show');
    }

    public function store()
    {
        $target_dir = base_path('storage/uploads/');
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            dd('fileExists');
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            dd('Sorry, your file is too large.');
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            dd('Sorry, only JPG, JPEG, PNG & GIF files are allowed');
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


        dd('uploaded');
    }
}
