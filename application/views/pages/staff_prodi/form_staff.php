<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Pendukung Keputusan</title>

    <?php $this->load->view('assets/stylesheet') ?>
</head>

<body>
    <div id="wrapper">
        <?php $this->load->view('master/header') ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tambah Data</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                Form Staff Prodi
                            </div>
                            <div class="panel-body">
                                <form action="" method="post">
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Nama</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="nama" placeholder="Nama"
                                                required=""
                                                value="<?php if(isset($data_staff)) echo $data_staff->nama; ?>">
                                                <?=form_error('nama')?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Username</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="username" placeholder="Username"
                                                required=""
                                                value="<?php if(isset($data_staff)) echo $data_staff->username; ?>">
                                                <?=form_error('username')?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="email" name="email" placeholder="Email"
                                                required=""
                                                value="<?php if(isset($data_staff)) echo $data_staff->email; ?>">
                                                <?=form_error('email')?>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Prodi</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select name="prodi" class="form-control" required>
                                                <option value="">Pilih Program Studi</option>
                                                <option value="TI" <?php if(isset($data_staff) && $data_staff->prodi == "TI") echo "selected" ?>>Teknik Informatika</option>
                                                <option value="SI" <?php if(isset($data_staff) && $data_staff->prodi == "SI") echo "selected" ?>>Sistem Informasi</option>   
                                            </select>
                                            <?=form_error('prodi')?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Password</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="password" name="password" class="form-control" required>
                                            <?=form_error('password')?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input type="submit" name="kirim" class="btn btn-md btn-success" value="Simpan">
                                            <button type="reset" class="btn btn-md btn-warning"><i
                                                    class="fa fa-undo"></i> Ulangi</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript') ?>

</html>