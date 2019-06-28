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
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success">
                            Selamat Datang <strong><?php echo $profile->nama; ?></strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h4>Tentang Promethee</h4>
                            </div>
                            <div class="panel-body">
                                <p align="justify">
                                    PROMETHEE adalah metode penentuan urutan atau prioritas dalam analisis
                                    multikriteria. Metode promethee mampu mengakomodir kriteria pemilihan yang bersifat
                                    kuantitatif dan kualitatif. Masalah utamanya adalah kesederhanaan, kejelasan dan
                                    kestabilan. Dugaan dari dominasi kriteria yang digunakan adalah penggunaan nilai
                                    dalam hubungan outranking yaitu dugaan dari dominasi antar alternatif terhadap suatu
                                    kriteria yang digunakan, dalam promethee adalah penggunaan nilai dalam hubungan
                                    antar nilai perankingan antar alternatif. Dalam metode ini informasi penting
                                    diberikan dari perbedaan dengan mengevaluasi suatu kriteria dan yang harus
                                    diperhatikan dalam menganalisa yaitu perbedaan terbesar, intensitas yang kuat dalam
                                    pilihan untuk suatu kriteria diatas yang lainnya (Sanada, 2013).
                                </p>
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