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
                                Kriteria Penerima Bantuan
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><?php echo $data_kriteria[0]['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bobot</td>
                                        <td>:</td>
                                        <td><?php echo $data_kriteria[0]['bobot']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis</td>
                                        <td>:</td>
                                        <td><?php echo $data_kriteria[0]['jenis']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4>Subkriteria</h4>
                                        </td>
                                        <td></td>
                                        <td>
                                            <?php if ($profile->level=='superadmin'){ ?>

                                            <a href="<?=base_url()?>kriteria/tambah_sub?id=<?php echo $data_kriteria[0]['id'] ?>"
                                                class="btn btn-sm btn-success" style="float: right;">
                                                <i class="fa fa-plus"></i> Tambah
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Bobot</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data_kriteria as $sub){ ?>
                                                    <?php if ($sub['subkriteria_id'] != ""){ ?>
                                                    <tr>
                                                        <td><?php echo $sub['nama_subkriteria']; ?></td>
                                                        <td><?php echo $sub['bobot_subkriteria']; ?></td>
                                                        <td>
                                                            <?php if ($profile->level=='superadmin'){ ?>

                                                            <a href="<?=base_url()?>kriteria/ubah_sub?id=<?php echo $sub['subkriteria_id'] ?>&kriteria_id=<?php echo $data_kriteria[0]['id']?>"
                                                                class="btn btn-xs btn-warning" title="Ubah">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a href="<?=base_url()?>kriteria/hapus_sub?id=<?php echo $sub['subkriteria_id'] ?>&kriteria_id=<?php echo $data_kriteria[0]['id']?>"
                                                                class="btn btn-xs btn-danger" title="Hapus"
                                                                onclick="return confirm('Apakah anda yakin ingin menghapus?')">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
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