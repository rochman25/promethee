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
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"  style="margin-top:30px">
                    <form action="" method="POST">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label>Periode</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="periode">
                                                <option value="">Pilih Periode</option>
                                                <?php foreach($periode as $key){ ?>
                                                <option value="<?=$key['id']?>"><?=$key['nama']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-success" name="kirim" value="Tampilkan">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if (isset($datas)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Data Hasil Seleksi </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding-bottom: 20px">
                            <div>
                                Data Riwayat Penialain Dosen Periode <?=$datas[0]['nama_periode']?>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>NIDN</th>
                                            <th>Nama</th>
                                            <th>Nilai</th>
                                            <th>Ranking</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                        ?>
                                        <?php foreach ($datas as $data): ?>
                                        <tr>
                                            <td><?php echo $data['nidn']; ?></td>
                                            <td><?php echo $data['nama']; ?></td>
                                            <td><?php echo $data['nilai']; ?></td>
                                            <td><?php echo $no++ ?></td>
                                        </tr>
                                        <?php endforeach;?>

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
            <?php endif;?>
        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript')?>

</html>