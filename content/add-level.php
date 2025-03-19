<?php
    if(isset($_POST["save"])) {
        $level_name = $_POST['level_name'];
        
        $insert = mysqli_query($koneksi, "INSERT INTO levels (level_name) VALUES('$level_name')");
        if($insert){
            header("location:?page=level&add=success");
        }
    }

    if(isset($_POST["edit"])) {
        $id = $_GET['edit'];
        $level_name = $_POST['level_name'];

        $update = mysqli_query($koneksi, "UPDATE levels SET level_name='$level_name' WHERE id = '$id'");
        if($update){
            header("location:?page=level&update=success");
        }
    }

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi,"SELECT * FROM levels WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" align="center">
                <h3><?php echo isset($_GET['edit']) ? "Edit" : "Create New" ." "?> Level</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Nama Level</label>
                            <input value="<?= isset($_GET['edit']) ? $rowEdit['level_name'] : ''?>" type="text" class="form-control" name="level_name" required placeholder="Enter Level Name">
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