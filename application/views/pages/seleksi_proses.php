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
                <div class="col-lg-12" style="margin-top:30px">
                    <form action="" method="POST">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label>Periode</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="periode" required>
                                                <option value="">Pilih Periode</option>
                                                <?php foreach($periode as $key){ ?>
                                                    <option value="<?=$key['id']?>" <?php echo set_select('periode',$key['id']) ?> ><?=$key['nama']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-success" name="kirim_periode" value="Tampilkan">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if($this->input->post('kirim_periode')){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Seleksi Dosen Berprestasi</h1>
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
                                                    <input type="hidden" name="id_kriteria[<?=$value['id']?>]" value="<?=$value['id']?>">
                                                    <select class=" form-control"
                                                        name="tipe[<?php echo $value['id'] ?>]">
                                                        <option value="">Tipe</option>
                                                        <option value="1" <?php if(array_key_exists('input_parameter',$value) && $value['input_parameter'][0]['tipe'] == 1){ echo 'selected'; } ?>>1 (Biasa)</option>
                                                        <option value="2" <?php if(array_key_exists('input_parameter',$value) && $value['input_parameter'][0]['tipe'] == 2){ echo 'selected'; } ?>>2 (Quasi)</option>
                                                        <option value="3" <?php if(array_key_exists('input_parameter',$value) && $value['input_parameter'][0]['tipe'] == 3){ echo 'selected'; } ?>>3 (Linier)</option>
                                                        <option value="4" <?php if(array_key_exists('input_parameter',$value) && $value['input_parameter'][0]['tipe'] == 4){ echo 'selected'; } ?>>4 (Linier quasi)</option>
                                                        <option value="5" <?php if(array_key_exists('input_parameter',$value) && $value['input_parameter'][0]['tipe'] == 5){ echo 'selected'; } ?>>5 (level)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="q[<?php echo $value['id'] ?>]" placeholder="Parameter q"
                                                        required value="<?php if(array_key_exists('input_parameter',$value)){ echo $value['input_parameter'][0]['q']; } ?>">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="p[<?php echo $value['id'] ?>]" placeholder="Parameter p"
                                                        required value="<?php if(array_key_exists('input_parameter',$value)){ echo $value['input_parameter'][0]['p']; } ?>">
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12" align="center">
                                    <input type="hidden" name="periode_id" value="<?=$id_periode?>">
                                    <input type="submit" class="btn btn-lg btn-info" name="kirim" value="Mulai Seleksi">
                                </div>
                            </form>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <?php } ?>

        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript') ?>

</html>