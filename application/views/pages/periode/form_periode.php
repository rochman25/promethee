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
                                Form Periode
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
                                                value="<?php if(isset($data_periode)) echo $data_periode->nama; ?>">
                                                <?=form_error('nama')?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Keterangan (optional)</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" name="keterangan" placeholder="Keterangan "><?php if(isset($data_periode)) echo $data_periode->keterangan; ?></textarea>
                                        </div>
                                    </div>
                                    <div id="sub"></div>

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