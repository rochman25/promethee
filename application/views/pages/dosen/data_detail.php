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
                        <h1 class="page-header">Detail Data</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Data Detail Dosen
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><?php echo $data_calon['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td><?php echo $data_calon['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Program Studi</td>
                                        <td>:</td>
                                        <td><?php echo $data_calon['prodi']; ?></td>
                                    </tr>
                                    <?php foreach ($data_calon['kriteria'] as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td>:</td>
                                        <td><?php echo $value['value'] ?></td>
                                    </tr>
                                    <?php endforeach ?>

                                </table>
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