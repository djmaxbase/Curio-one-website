<?php
session_start();
$correct_password = "onki";
$json_file = __DIR__ . "/data/blog.json";
$image_folder = __DIR__ . "/data/blog_img/";

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $password = $_POST["password"] ?? "";
    if ($password === $correct_password) $_SESSION["logged_in"] = true;
    else $error = "Incorrect password.";
}


$blogs = [];
if (file_exists($json_file)) $blogs = json_decode(file_get_contents($json_file), true);


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['new_blog']) && !empty($_SESSION["logged_in"])) {
    $title = $_POST['title'] ?? '';
    $text = $_POST['text'] ?? '';
    $time = date("Y-m-d H:i");
    $image_name = '';
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_folder . $image_name);
    }
    $new_id = !empty($blogs) ? end($blogs)['id'] + 1 : 1;
    $blogs[] = ['id'=>$new_id,'title'=>$title,'time'=>$time,'text'=>$text,'image'=>$image_name];
    file_put_contents($json_file, json_encode($blogs, JSON_PRETTY_PRINT));
    $success = "Blog added successfully!";
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_blog']) && !empty($_SESSION["logged_in"])) {
    $edit_id = intval($_POST['id']);
    foreach ($blogs as &$blog) {
        if ($blog['id'] === $edit_id) {
            $blog['title'] = $_POST['title'];
            $blog['text'] = $_POST['text'];
            $blog['time'] = date("Y-m-d H:i");
            if (!empty($_FILES['image']['name'])) {
                $image_name = basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_folder . $image_name);
                $blog['image'] = $image_name;
            }
            break;
        }
    }
    unset($blog);
    file_put_contents($json_file, json_encode($blogs, JSON_PRETTY_PRINT));
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


if (isset($_GET['delete']) && !empty($_SESSION["logged_in"])) {
    $delete_id = intval($_GET['delete']);
    $blogs = array_values(array_filter($blogs, fn($b)=>$b['id']!==$delete_id));
    file_put_contents($json_file, json_encode($blogs, JSON_PRETTY_PRINT));
    $success = "Blog deleted successfully!";
}


$editing_blog = null;
if (isset($_GET['edit']) && !empty($_SESSION["logged_in"])) {
    $edit_id = intval($_GET['edit']);
    foreach ($blogs as $b) if ($b['id']===$edit_id) $editing_blog=$b;
}


usort($blogs, fn($a,$b)=>$b['id']<=>$a['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Curio one | admin</title>
    <link rel="stylesheet/less" type="text/css" href="css/admin.less">
    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>
    <script>
        function confirmDelete(id) { if(confirm("Delete this blog post?")) window.location="?delete="+id; }
    </script>
</head>
<body>
<?php if(!empty($_SESSION["logged_in"])): ?>
<header>
    <h1>Admin Panel</h1>
    <a href="?logout=1">Logout</a>
</header>
<div class="container">
    <?php if(!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <h2><?= $editing_blog?"Edit Blog Post":"Add New Blog Post" ?></h2>
    <form method="post" enctype="multipart/form-data">
        <?php if($editing_blog): ?>
            <input type="hidden" name="edit_blog" value="1">
            <input type="hidden" name="id" value="<?= $editing_blog['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="new_blog" value="1">
        <?php endif; ?>
        <input type="text" name="title" placeholder="Title" required value="<?= $editing_blog['title'] ?? '' ?>">
        <textarea name="text" rows="5" placeholder="Text" required><?= $editing_blog['text'] ?? '' ?></textarea>
        <input type="file" name="image" accept="image/*">
        <?php if($editing_blog && !empty($editing_blog['image'])): ?>
            <p>Current image: <?= htmlspecialchars($editing_blog['image']) ?></p>
        <?php endif; ?>
        <button type="submit"><?= $editing_blog?"Update Blog":"Add Blog" ?></button>
        <?php if($editing_blog): ?><a href="<?= $_SERVER['PHP_SELF'] ?>" class="cancel">Cancel</a><?php endif; ?>
    </form>

    <h2 id="abp">All Blob Posts</h2>
    <?php if(!empty($blogs)): foreach($blogs as $blog): ?>
        <div class="blog">
            <h3><?= htmlspecialchars($blog['title']) ?></h3>
            <time><?= htmlspecialchars($blog['time']) ?></time>
            <?php if(!empty($blog['image'])): ?>
                <img src="data/blog_img/<?= htmlspecialchars($blog['image']) ?>" alt="Blog image">
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($blog['text'])) ?></p>
            <div class="blog-actions">
                <a href="?edit=<?= $blog['id'] ?>" class="edit">Edit</a>
                <a href="javascript:void(0);" onclick="confirmDelete(<?= $blog['id'] ?>)" class="delete">Delete</a>
            </div>
        </div>
    <?php endforeach; else: ?>
        <p>No blogs found.</p>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="login-container">
    <h2>Admin Login</h2>
    <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="hidden" name="login" value="1">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="index.php"><< back</a>
    </form>
</div>
<?php endif; ?>
</body>
</html>
