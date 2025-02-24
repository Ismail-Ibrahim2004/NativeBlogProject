<?php
require_once('Header.php');
// session_start();
$user = unserialize($_SESSION["user"]);
$my_posts = $user->my_posts($user->id);
?>
<section class="w-100 px-4 py-5" style="background-color:rgb(147, 149, 142); border-radius: .5rem .5rem 0 0;">
    <div class="row d-flex justify-content-center">
        <div class="col col-md-9 col-lg-7 col-xl-6">
            <div class="card" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex">
                        <div class="col-xl-4">
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Profile Picture</div>
                                <div class="card-body text-center">
                                    <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'User_image_updated_successfully') { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>done</strong> User image updated successfully
                                    </div>
                                    <?php } ?>
                                    <img class="img-account-profile rounded-circle border"
                                        style="width: 100px; height: 100px; border-radius: 100px;"
                                        src="<?= !empty($user->image) ? $user->image : 'http://bootdey.com/img/Content/avatar/avatar7.png' ?>"
                                        alt="Profile">
                                    <form action="store_user_image.php" method="post" enctype="multipart/form-data">
                                        <input type="file" name="image" style="width: 100%">
                                        Upload new image</input>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><?= $user->name ?></h5>
                            <p class="mb-2 pb-1"><?= $user->role ?></p>
                            <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                                <div>
                                    <p class="small text-muted mb-1">Articles</p>
                                    <p class="mb-0">41</p>
                                </div>
                                <div class="px-3">
                                    <p class="small text-muted mb-1">Followers</p>
                                    <p class="mb-0">976</p>
                                </div>
                                <div>
                                    <p class="small text-muted mb-1">Rating</p>
                                    <p class="mb-0">8.5</p>
                                </div>
                            </div>
                            <div class="d-flex pt-1">
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-outline-primary me-1 flex-grow-1">Chat</button>
                                <button type="button" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary flex-grow-1">Follow</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-6 offset-3 bg-secondary mt-5 rounded-2">
            <h1 class="text-white text-center">Share your idea</h1>
        </div>
        <div class="col-6 offset-3 bg-secondary mt-5 rounded-2 pt-5">
            <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'done') { ?>
            <div class="alert alert-success" role="alert">
                <strong>done</strong> Post added successfully
            </div>
            <?php } ?>
            <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'requird_fields') { ?>
            <div class="alert alert-danger" role="alert">
                <strong>Required fields</strong> Required fields are missing
            </div>
            <?php } ?>
            <form action="storePost.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="" aria-describedby="helped" />
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" placeholder="" aria-describedby="helped"></textarea>
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" placeholder="" aria-describedby="helped" />
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <button type="submit" class="btn btn-primary my-5">Submit</button>
            </form>
        </div>
    </div>

    <?php foreach ($my_posts as $post) { ?>
    <div class="col-6 offset-3 bg-info mt-5 rounded-2">
        <div class="card">
            <?php if (!empty($post["image"])) { ?>
            <img class="card-img-top" style="height: 300px;" src="<?= $post["image"] ?>" alt="Title" />
            <?php } ?>
            <div class="card-body">
                <h4 class="card-title"><?= $post["title"] ?></h4>
                <p class="card-text"><?= $post["content"] ?></p>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                        <div class="card-body p-4">
                            <form action="store_Comment.php" method="post">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" id="addANote" name="comment" class="form-control"
                                        placeholder="Type comment..." />
                                    <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
                                    <button type="submit" class="btn btn-primary mt-2 ms-2">+ Add a note</button>
                                </div>
                            </form>
                            <?php
                            $comments =$user->get_post_comment($post["id"]);
                            foreach ($comments as $comment) {
                            ?>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <p><?= $comment["comment"] ?></p>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <img src="<?= !empty($comment['image']) ? $comment['image'] : 'http://bootdey.com/img/Content/avatar/avatar7.png' ?>"
                                                alt="avatar" width="25" height="25" />
                                            <p class="small mb-0 ms-2"><?= $comment["name"] ?></p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <p class="small text-muted mb-0"><?= $comment["created_at"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php require_once('Footer.php'); ?>