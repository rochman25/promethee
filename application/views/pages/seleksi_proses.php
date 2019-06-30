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
                    <h1 class="page-header">Seleksi Dosen Terbaik</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="padding-bottom: 20px">
                            <div>
                                <h4>Tabel Normalisasi Bobot Kriteria</h4>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="<?=base_url()?>proses/seleksi" method="POST">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle;">No</th>
                                                <th rowspan="2" style="vertical-align: middle;">Kriteria</th>
                                                <th rowspan="2" style="vertical-align: middle;">Bobot</th>
                                                <th rowspan="2" style="vertical-align: middle;">Jenis</th>
                                                <th width="100" rowspan="2" style="vertical-align: middle;">Tipe</th>
                                                <th colspan="2" style="text-align: center">Parameter</th>
                                            </tr>
                                            <tr>
                                                <th width="140" class="text-center">q</th>
                                                <th width="140" class="text-center">p</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x= 1; ?>
                                            <?php foreach ($data_kriteria['data'] as $key => $value): ?>
                                            <tr>
                                                <td><?php echo $x++ ?></td>
                                                <td><?php echo $key ?></td>
                                                <td><?php echo $value['bobot']/$data_kriteria['ekstra']['total_bobot'];?>
                                                </td>
                                                <td><?php echo  $value['jenis'] ?></td>
                                                <td>
                                                    <select class=" form-control"
                                                        name="tipe[<?php echo $value['id'] ?>]">
                                                        <option value="">Tipe</option>
                                                        <option value="2">2</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="q[<?php echo $value['id'] ?>]" placeholder="Parameter q"
                                                        required>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="p[<?php echo $value['id'] ?>]" placeholder="Parameter p"
                                                        required>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12" align="center">
                                    <input type="submit" class="btn btn-lg btn-info" name="kirim" value="Mulai Seleksi">
                                </div>
                            </form>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript') ?>

</html>