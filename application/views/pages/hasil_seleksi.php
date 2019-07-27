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
                    <h1 class="page-header">Seleksi Calon Penerima Program Bantuan</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading" style="padding-bottom: 20px">
                            <div>
                                <h4>Tabel Normalisasi Bobot Kriteria</h4>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;">No</th>
                                            <th rowspan="2" style="vertical-align: middle;">Kriteria</th>
                                            <!-- <th rowspan="2" style="vertical-align: middle;">Bobot</th> -->
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
                                        <?php $x = 1; ?>
                                        <?php foreach ($data_kriteria['data'] as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $x++ ?></td>
                                                <td><?php echo $key ?></td>
                                                <!-- <td><?php //echo $value['bobot'] 
                                                            ?></td> -->
                                                <!-- <td><?php //echo $value['bobot'] / $data_kriteria['ekstra']['total_bobot']; 
                                                            ?> -->
                                                </td>
                                                <td><?php echo $value['jenis'] ?></td>
                                                <td>
                                                    <?php echo $tipe[$value['id']] ?>
                                                </td>
                                                <td>
                                                    <?php echo $q[$value['id']] ?>
                                                </td>
                                                <td>
                                                    <?php echo $p[$value['id']] ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse1">Hasil Seleksi</a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <h3>Tabel Hasil Seleksi</h3>
                                    <div class="panel panel-info">
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <table id="dataTables-result" class="table table-bordered ctr">
                                                <thead>
                                                    <tr>
                                                        <th width="100">Alternatif</th>
                                                        <th>Nama</th>
                                                        <th>Leaving Flow</th>
                                                        <th>Entering Flow</th>
                                                        <th>Net Flow</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($hasil as $key => $value) : ?>
                                                        <tr>
                                                            <td><?php echo $key ?></td>
                                                            <td><?php echo $value['nama']; ?></td>
                                                            <td><?php echo $value['leaving'] ?></td>
                                                            <td><?php echo $value['entering'] ?></td>
                                                            <td><?php echo $value['net_flow'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse2">Ranking</a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <h3>Tabel Ranking</h3>
                                    <div class="panel panel-info">
                                        <!-- /.panel-heading -->
                                        <div class="panel-body table-responsive">
                                            <table id="dataTables-ranking" class="table table-bordered ctr">
                                                <thead>
                                                    <tr>
                                                        <th>Ranking</th>
                                                        <th>Alternatif</th>
                                                        <th>Nilai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($ranking_hasil as $key => $value) : ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?php echo $value['nama'] ?></td>
                                                            <td><?php echo $value['nilai'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse3">Detail Perhitungan</a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#collapse4">Matriks Kecocokan Alternatif</a>
                                                </h4>
                                            </div>
                                            <div id="collapse4" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <h3>Tabel Matriks Kecocokan</h3>
                                                    <div class="panel panel-info">
                                                        <!-- /.panel-heading -->
                                                        <div class="panel-body">
                                                            <div class="table-responsive">
                                                                <table id="dataTables-kecocokan" class="table table-bordered ctr">
                                                                    <thead>
                                                                        <tr>
                                                                            <th rowspan="2">Alternatif</th>
                                                                            <?php $c = 1; ?>
                                                                            <?php foreach ($data_kriteria['data'] as $key => $value) : ?>
                                                                                <th>C<?php echo $c++; ?></th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <?php foreach ($data_kriteria['data'] as $key => $value) : ?>
                                                                                <th><?php echo $value['nama']; ?></th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($data_calon['data'] as $key => $value) : ?>
                                                                            <tr>
                                                                                <td><?php echo $key ?></td>
                                                                                <?php foreach ($value['kriteria'] as $key_sub => $value_sub) : ?>
                                                                                    <td><?php echo $value_sub['nama_subkriteria'] == 'input' ? $value_sub['value'] : $value_sub['bobot_subkriteria']; ?>
                                                                                    </td>
                                                                                <?php endforeach; ?>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php foreach ($data_kriteria['data'] as $key => $value) : ?>
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" href="#<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></a>
                                                    </h4>
                                                </div>
                                                <?php //foreach ($data_kriteria['data'] as $key_k => $value_k) : 
                                                ?>
                                                <div id="<?php echo $value['id'] ?>" class="panel-collapse collapse">
                                                    <div class="panel-body table-responsive">
                                                        <h3>Tabel Jarak Kriteria <?php echo $value['nama']; ?></h3>
                                                        <div class="panel panel-info">
                                                            <!-- /.panel-heading -->
                                                            <div class="panel-body table-responsive">
                                                                <table class="table table-bordered ctr">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="2"><?= $value['nama'] ?></td>
                                                                            <td>a</td>
                                                                            <td>b</td>
                                                                            <td>d(jarak)</td>
                                                                            <td>|d|</td>
                                                                            <td>P(Preferensi)</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($jarak_kriteria[$value['nama']] as $key => $value) :
                                                                            // die(json_encode($key));
                                                                            // var_dump($key);
                                                                            $a = 0;
                                                                            ?>
                                                                            <?php //foreach ($data_calon['data'] as $key) : ?>
                                                                                <?php
                                                                                foreach ($data_calon['data'] as $key_a) :
                                                                                    ?>
                                                                                    <tr>
                                                                                        <?php if ($key_a['nidn'] != $key) { ?>
                                                                                            <td><?php echo $key ?></td>
                                                                                            <td><?php echo $key_a['nidn'] ?></td>
                                                                                            <td><?php echo $value['a'][$a] ?></td>
                                                                                            <td><?php echo $value['b'][$a] ?></td>
                                                                                            <td><?php echo $value['d'][$a] ?></td>
                                                                                            <td><?php echo $value['D'][$a]
                                                                                                ?></td>
                                                                                            <td><?php echo $value['p'][$a] ?></td>
                                                                                        <?php } ?>
                                                                                    </tr>
                                                                                <?php 
                                                                                $a++;
                                                                                endforeach; ?>
                                                                                <?php
                                                                                //$a++;
                                                                                //$sim++;
                                                                            //endforeach;
                                                                         endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- /.panel-body table-responsive -->
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer"></div>
                                                </div>
                                                <?php //endforeach 
                                                ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="nav nav-tabs"> -->
                    <!-- <li class="active"><a data-toggle="tab" href="#result">Hasil Seleksi</a></li>
                        <li><a data-toggle="tab" href="#ranking">Ranking</a></li>
                        <li><a data-toggle="tab" href="#kecocokan">Matriks Kecocokan Alternatif</a></li> -->
                    <?php //foreach ($data_kriteria['data'] as $key => $value) : 
                    ?>
                    <!-- <li><a data-toggle="tab" href="#<?php echo $value['id'] ?>"><?php echo $value['nama'] ?></a>
                                        </li> -->
                    <?php //endforeach 
                    ?>
                    <!-- </ul> -->

                    <div class="tab-content">
                        <!-- <div id="result" class="tab-pane fade in active">
                        </div> -->
                        <!-- <div id="ranking" class="tab-pane fade">
                        </div> -->
                        <!-- <div id="kecocokan" class="tab-pane fade">
                        </div> -->

                        <?php foreach ($data_kriteria['data'] as $key_k => $value_k) : ?>
                            <div id="<?php echo $value_k['id'] ?>" class="tab-pane fade">
                                <h3>Tabel Jarak Kriteria <?php echo $value_k['nama']; ?></h3>
                                <div class="panel panel-info">
                                    <!-- /.panel-heading -->
                                    <div class="panel-body table-responsive">
                                        <table class="table table-bordered ctr">
                                            <thead>
                                                <tr>
                                                    <td colspan="2"><?= $value_k['nama'] ?></td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>d(jarak)</td>
                                                    <td>|d|</td>
                                                    <td>P(Preferensi)</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $a = 0;
                                                $sim = 1;
                                                ?>
                                                <?php foreach ($data_calon['data'] as $key) : ?>
                                                    <?php
                                                    foreach ($data_calon['data'] as $key_a) :
                                                        ?>
                                                        <tr>
                                                            <?php if ($key != $key_a) { ?>
                                                                <td><?php echo $key['nidn'] ?></td>
                                                                <td><?php echo $key_a['nidn'] ?></td>
                                                                <td><?php echo $value['a'][$a] ?></td>
                                                                <td><?php echo $value['b'][$a] ?></td>
                                                                <td><?php echo $value['d'][$a] ?></td>
                                                                <td><?php echo $value['D'][$a]
                                                                    ?></td>
                                                                <td><?php echo $value['p'][$a] ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <?php
                                                    $a++;
                                                    $sim++;
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.panel-body table-responsive -->
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->
    </div>
</body>
<?php $this->load->view('assets/javascript') ?>

</html>