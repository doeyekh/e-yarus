<div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>
            
            <li class="sidebar-item  <?= $menu == 'dashboard' ? 'active' : '' ?>">
                <a href="<?= base_url(); ?>" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-item  has-sub <?= $menu == 'master' ? 'active' : '' ?>">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-collection-fill"></i>
                    <span>Master Data</span>
                </a>
                <ul class="submenu <?= $menu == 'master' ? 'active' : '' ?>">
                    <li class="submenu-item <?= $sub == 'tahun' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/tahun-ajar') ?>">Tahun Pelajaran</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'sekolah' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-sekolah') ?>">Sekolah</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'pesantren' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-pesantren') ?>">Pesantren</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'kelas' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-kelas') ?>">Kelas</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'kantin' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-kantin') ?>">Kantin / Warung</a>
                    </li>
                    
                </ul>
            </li>

            <li class="sidebar-item  has-sub <?= $menu == 'guru' ? 'active' : '' ?>">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-people-fill"></i>
                    <span>Guru / Asyatid </span>
                </a>
                <ul class="submenu <?= $menu == 'guru' ? 'active' : '' ?>">

                    <!-- Hover added -->
                    <li class="submenu-item <?= $sub == 'guru-aktif' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/guru-aktif') ?>">Guru Aktif</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'wakasek' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-wakasek') ?>">Penugasan</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'guru-nonaktif' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/guru-nonaktif') ?>"> <span class="text-danger">Guru Non Aktif</span></a>
                    </li>
                    
                </ul>
            </li>
            <li class="sidebar-item  has-sub <?= $menu == 'siswa' ? 'active' : '' ?>">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-people-fill"></i>
                    <span>Siswa / Santri </span>
                </a>
                <ul class="submenu <?= $menu == 'siswa' ? 'active' : '' ?>">

                    <!-- Hover added -->
                    <li class="submenu-item <?= $sub == 'siswa-aktif' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/siswa-aktif') ?>">Santri Aktif</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'orang-tua' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/ortu') ?>">Orang Tua</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'berkas' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-berkas') ?>">Berkas</a>
                    </li>

                    <li class="submenu-item <?= $sub == 'alumni' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-alumni') ?>"> <span class="text-danger">Alumni</span></a>
                    </li>
                    
                </ul>
            </li>

            <li class="sidebar-item <?= $menu == 'kartu' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/kartu-santri') ?>" class='sidebar-link'>
                    <i class="bi bi-credit-card"></i>
                    <span>Kartu </span>
                </a>
            </li>
            
        </ul>
    </div>