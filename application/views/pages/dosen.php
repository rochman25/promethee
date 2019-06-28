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
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Data Dosen</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding-bottom: 20px">
                            <div>
                                Tabel Dosen
                                <a href="index.php?url=data_calon_tambah" class="btn btn-sm btn-success"
                                    style="float: right;"><i class="fa fa-plus"></i> Tambah</a>

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Program Studi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x=1; ?>
                                        <?php if(isset($datas)): ?>
                                        <?php foreach($datas as $data): ?>
                                        <tr>
                                            <td align="center"><?php echo $x++; ?></td>
                                            <td><?php echo $data['nama']; ?></td>
                                            <td><?php echo $data['jenis_kelamin']; ?></td>
                                            <td><?php echo $data['prodi']; ?></td>

                                            <td align="center">
                                                <a href="index.php?url=data_calon_lihat&id=<?php echo $data['id'] ?>"
                                                    class="btn btn-xs btn-info" title="Lihat">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="index.php?url=data_calon_ubah&id=<?php echo $data['id'] ?>"
                                                    class="btn btn-xs btn-warning" title="Ubah">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="config/calon/proses_hapus.php?&id=<?php echo $data['id'] ?>"
                                                    class="btn btn-xs btn-danger" title="Hapus"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus?')">
                                                    <i class="fa fa-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript') ?>

</html>