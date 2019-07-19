<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=base_url('admin/index')?>">SPK | PROMETHEE METHOD</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?=base_url('admin/pengaturan')?>"><i class="fa fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?=base_url('admin/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?=base_url('admin/index')?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="<?=base_url('periode')?>"><i class="fa fa-table fa-fw"></i> Data Periode</a>
                </li>
                <li>
                    <a href="<?=base_url('kriteria')?>"><i class="fa fa-table fa-fw"></i> Data Kriteria</a>
                </li>
                <!-- <li>
                    <a href="<?=base_url('dosen')?>"><i class="fa fa-table fa-fw"></i> Data Dosen</a>
                </li> -->
                <li>
                    <a href="<?=base_url('proses')?>"><i class="fa fa-edit fa-fw"></i>Proses & Hasil Seleksi</a>
                </li>
                <li>
                    <a href="<?=base_url('riwayat')?>"><i class="fa fa-history fa-fw"></i>Riwayat Seleksi</a>
                </li>
                <?php if ($profile->level=='superadmin'): ?>
                <li>
                    <a href="#"><i class="fa fa-gear"></i> Pengaturan<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=base_url('staff')?>">Staff Prodi</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <?php endif ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>