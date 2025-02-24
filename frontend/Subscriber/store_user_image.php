 <?php 
session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);
if (!empty($_FILES["image"]["name"])) {
    $imageName = "../../images/users/".$_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"],$imageName );
    $user->upated_profile_pic($imageName, $user->id);
    $user->image = $imageName;
    $_SESSION["user"] = serialize($user);
    header("Location: profile.php?msg=User_image_updated_successfully");
}else {
    header("Location: profile.php?msg=required_image");
}
