<?php
    if(isset($_POST["save"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $id_level = $_POST['id_level'];
        
        $insert = mysqli_query($koneksi, "INSERT INTO users (id_level, name, email, password) VALUES('$id_level','$name', '$email', '$password')");
        if($insert){
            header("location:?page=user&add=success");
        }
    }
    
    if(isset($_POST["edit"])) {
        $id = $_GET['edit'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $id_level = $_POST['id_level'];

        if ($_POST['password']) {
            $password = sha1($_POST['password']);
        } else {
            $password = $rowEdit['password'];
        }

        $update = mysqli_query($koneksi, "UPDATE users SET id_level='$id_level', name='$name', email='$email', password='$password' WHERE id = '$id'");
        if($update){
            header("location:?page=user&update=success");
        }
    }

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi,"SELECT * FROM users WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

// level 
$queryLev = mysqli_query($koneksi, "SELECT * FROM levels ORDER BY id DESC");
$rowLev = mysqli_fetch_all($queryLev, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" align="center">
                <h3>Create User</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3">
                   <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Pilih Level</label>
                            <select class="form-control" name="id_level" id="">
                                <option value="" hidden> Pilih Level </option>
                                <?php foreach ($rowLev as $lvl) : ?>
                                    <option value="<?php echo $lvl['id'] ?>">
                                        <?php echo $lvl['level_name']?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">User Name</label>
                            <input value="<?= isset($_GET['edit']) ? $rowEdit['name'] : ''?>" type="text" class="form-control" name="name" required placeholder="Enter User Name">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input value="<?= isset($_GET['edit']) ? $rowEdit['email'] : ''?>" type="email" class="form-control" name="email" required placeholder="Enter Email User">
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input value="<?= isset($_GET['edit']) ? $rowEdit['password'] : ''?>" type="password" class="form-control" name="password" required placeholder="Enter Password">
                        </div>


                        <div class="mb-3">
                            <button class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'save' ?>" type="submit">Save</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>