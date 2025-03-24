<?php

if (empty($_SESSION['click_count'])){
    $_SESSION['click_count'] = 0;
}

if(isset($_POST["save"])) {
    $trans_code = $_POST['trans_code'];
    $order_date = $_POST['order_date'];
    $id_customer = $_POST['id_customer'];
    $order_end_date = $_POST['order_end_date'];
    
    $insert = mysqli_query($koneksi, "INSERT INTO trans_order (trans_code, order_date, id_customer, order_end_date) VALUES('$trans_code', '$order_date', '$id_customer', '$order_end_date')");
    // if($insert){
    //     header("location:?dashboard.php?page=trans-order");
    // }
    
    //id_service = $_POST['id_service'];
    $id_order = mysqli_insert_id($koneksi);
    $qty = isset($_POST["qty"]) ? $_POST["qty"] : 0;
    $notes = isset($_POST['notes']) ? $_POST['notes'] :'';
    $id_service = isset($_POST['id_service']) ? $_POST['id_service'] : 0;


    for ($i=0; $i < $_POST['countDisplay']; $i++) {
        $service_name = $_POST['service_name'];
        $cariId_service = mysqli_query($koneksi,"SELECT id FROM services WHERE service_name = '$service_name'");
        $rowId_service = mysqli_fetch_assoc($cariId_service);
        $id_service = isset($rowId_service['id']) ? $rowId_service['id'] : 0 ;
        

        $instOrderDet = mysqli_query($koneksi,"INSERT INTO trans_order_detail (id_order, id_service, qty, notes) VALUES ('$id_order', '$id_service', '$qty[$i]', '$notes[$i]')");
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

// query edittt
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi,"SELECT * FROM users WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

// query level 
$queryLev = mysqli_query($koneksi, "SELECT * FROM levels ORDER BY id DESC");
$rowLev = mysqli_fetch_all($queryLev, MYSQLI_ASSOC);

//query customers
$queryCustomers = mysqli_query($koneksi,"SELECT * FROM customers ORDER BY id DESC");
$rowCustomers = mysqli_fetch_all($queryCustomers, MYSQLI_ASSOC);

//query Services
$queryServices = mysqli_query($koneksi,"SELECT * FROM services ORDER BY id DESC");
$rowServices = mysqli_fetch_all($queryServices, MYSQLI_ASSOC);

// Transaksi, 032125001
$quetyTrans = mysqli_query($koneksi,"SELECT max(id) as id_trans FROM trans_order");
$rowTrans = mysqli_fetch_assoc($quetyTrans);
$id_trans = $rowTrans['id_trans'];
$id_trans++;

$kode_transaksi = "TR ".date("mdy") . sprintf("%03s", $id_trans);

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" align="center">
                <h3>Trans Order</h3>
            </div>
            <div class="card-body mt-3">

                   <form action="" method="post">
                    <input type='hidden' id="service_price">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3 row">
                                <div class="col-sm-4">
                                    <label for="">Kode Transaksi</label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="trans_code" value="<?php echo $kode_transaksi ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-4">
                                    <label for="">Order Date</label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="order_date">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-4">
                                    <label for="">Service</label>
                                </div>
                                <div class="col-sm-5">
                                    <select name="" id="id_service" class="form-control">
                                        <option value="" hidden>Choose Service</option>
                                        <?php foreach($rowServices as $rowService) : ?>
                                            <option value="<?php echo $rowService['id']?>"><?php echo $rowService['service_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Col - 6 -->

                        <div class="col-sm-6">
                            <div class="mb-3 row">
                                    <div class="col-sm-4">
                                        <label for="">Customer Name</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="id_customer">
                                            <option value="">Choose Customer</option>
                                            <?php foreach ($rowCustomers as $rowCustomer):?>
                                            <option value="<?php echo $rowCustomer['id']?>">
                                                <?php echo $rowCustomer['customer_name']?>
                                            </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <div class="mb-3 row">
                                <div class="col-sm-4">
                                    <label for="">Pickup Date</label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="order_end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-success btn-sm add-row">Add Row</button>
                                <input type="number" name="countDisplay" id="countDisplay" value="<?php echo    $_SESSION['click_count'] ?>" readonly>
                            </div>
                            <table class="table table-bordered table-order">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Service</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'save' ?>" type="submit">Save</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>