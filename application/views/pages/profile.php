<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Pendukung Keputusan</title>

    <?php $this->load->view('assets/stylesheet')?>
</head>

<body>
    <div id="wrapper">
        <?php $this->load->view('master/header')?>
        <!-- Page Content -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Pengaturan</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(!empty($this->session->flashdata('pesan'))) { ?>
                        <div class="alert alert-<?php echo $this->session->flashdata('warna'); ?> ">
                            <?php echo $this->session->flashdata('pesan'); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Form Pengguna
                            </div>
                            <div class="panel-body">
                                <form action="<?=base_url('admin/pengaturan')?>" method="POST">

                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Nama</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="nama" placeholder="Nama"
                                                value="<?php echo $profile->nama;?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Level</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="level" placeholder="Level"
                                                value="<?php echo $profile->level ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Username</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="username"
                                                placeholder="Username" value="<?php echo $profile->username ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Password Lama</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" name="password_lama"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <label>Password Baru</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" name="password_baru"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input type="submit" name="kirim" class="btn btn-md btn-primary" value="Simpan">
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
<?php $this->load->view('assets/javascript')?>

</html>