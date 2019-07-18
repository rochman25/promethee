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
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?=$mode?> Data</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                Form Dosen
                            </div>
                            <div class="panel-body">
                                <form action="" method="post">
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>NIDN</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="nidn" placeholder="NIDN"
                                                required=""
                                                value="<?php if(isset($data_calon)) echo $data_calon['nidn']; ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Nama</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="nama" placeholder="Nama"
                                                required=""
                                                value="<?php if(isset($data_calon)) echo $data_calon['nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Jenis Kelamin</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="radio" name="jenis_kelamin" value="Laki - Laki"
                                                <?php if(isset($data_calon) && $data_calon['jenis_kelamin']=='Laki - Laki') echo 'checked';  ?>>
                                            Laki - Laki
                                            <input type="radio" name="jenis_kelamin" value="Perempuan"
                                                <?php if(isset($data_calon) && $data_calon['jenis_kelamin']=='Perempuan') echo 'checked';  ?>>
                                            Perempuan
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label>Program Studi</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="prodi" required="">
                                                <option value=""> - Program Studi - </option>
                                                <option value="SI"
                                                    <?php if(isset($data_calon) && $data_calon['prodi']=='SI') echo 'selected';  ?>>
                                                    Sistem Informasi</option>
                                                <option value="TI"
                                                    <?php if(isset($data_calon) && $data_calon['prodi']=='TI') echo 'selected';  ?>>
                                                    Teknik Informatika</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php foreach ($datas as $data): ?>
                                    <div class="row form-group">
                                        <div class="col-lg-3">
                                            <label><?php echo $data[0]['nama']; ?></label>
                                        </div>
                                        <div class="col-lg-9">
                                            <?php if (isset($data_calon['kriteria'][$data[0]['nama']])): ?>
                                            <input type="hidden" name="old_sub_id[<?php echo $data[0]['id'] ?>]"
                                                value="<?php echo $data_calon['kriteria'][$data[0]['nama']]['id']; ?>">
                                            <?php else: ?>
                                            <input type="hidden" name="new_sub[<?php echo $data[0]['id']; ?>]"
                                                value="<?php echo $data[0]['id']; ?>">
                                            <?php endif ?>

                                            <?php if ($data[0]['nama_subkriteria']=='input'): ?>
                                            <input class="form-control" type="number" max=4 min=0
                                                name="value[<?php echo $data[0]['id']; ?>]"
                                                placeholder="<?php echo $data[0]['nama']; ?>"
                                                value="<?php if(isset($data_calon['kriteria'][$data[0]['nama']]['value'])) echo $data_calon['kriteria'][$data[0]['nama']]['value']; ?>">
                                            <input type="hidden" name="sub_id[<?php echo $data[0]['id'] ?>]"
                                                value="<?php echo $data[0]['subkriteria_id'] ?>">

                                            <?php else: ?>
                                            <select class="form-control" name="sub_id[<?php echo $data[0]['id'] ?>]">
                                                <option value="">- <?php echo $data[0]['nama']; ?> -</option>
                                                <?php foreach ($data as $sub): ?>
                                                <option value="<?php echo $sub['subkriteria_id'] ?>"
                                                    <?php if(isset($data_calon['kriteria'][$data[0]['nama']]) && $sub['nama_subkriteria']==$data_calon['kriteria'][$data[0]['nama']]['value']) echo "selected"; ?>>
                                                    <?php echo $sub['nama_subkriteria']; ?> </option>
                                                <?php endforeach ?>

                                            </select>
                                            <?php endif ?>

                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input type="submit" class="btn btn-md btn-success" name="kirim"
                                                value="Simpan">
                                            <button type="reset" class="btn btn-md btn-warning"><i
                                                    class="fa fa-undo"></i>
                                                Ulangi</button>
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