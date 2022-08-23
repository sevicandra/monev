<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <?php
        $kewenangan = '2';
        if ($kewenangan === '1') {
            $levels = [

                ['id' => 1, 'level' => 'halaman Utama'],
                ['id' => 2, 'level' => 'Pejabat Pembuat Komitmen']
            ];
        } else if ($kewenangan === '2') {
            $levels = [
                ['id' => 1, 'level' => 'halaman Utama'],
                ['id' => 2, 'level' => 'Pejabat Pembuat Komitmen'],
                ['id' => 3, 'level' => 'Bagian Keuangan']
            ];
        } else {
            $levels = [
                ['id' => 1, 'level' => 'halaman Utama']

            ];
        }

        $menus = [
            ['menu' => 'Dashboard', 'level' => 1, 'url' => '/dashboard'],
            ['menu' => 'Realisasi Unit', 'level' => 1, 'url' => '/realisasi-direktorat'],
            ['menu' => 'Realisasi PPK', 'level' => 1, 'url' => '/realisasi-ppk'],
            ['menu' => 'Data Tagihan', 'level' => 2, 'url' => '/tagihan'],
            ['menu' => 'Register Tagihan', 'level' => 2, 'url' => '/register'],
            ['menu' => 'Monitoring Tagihan', 'level' => 2, 'url' => '/monitoring-tagihan'],
            ['menu' => 'Pegawai Non DJKN', 'level' => 2, 'url' => '/pegawai-nondjkn'],
            ['menu' => 'Verifikasi', 'level' => 3, 'url' => '/verifikasi'],
            ['menu' => 'PPSPM', 'level' => 3, 'url' => '/ppspm'],
            ['menu' => 'Bendahara', 'level' => 3, 'url' => '/bendahara'],
            ['menu' => 'Arsip', 'level' => 3, 'url' => '/arsip'],
            ['menu' => 'Referensi', 'level' => 3, 'url' => '/referensi'],

        ];
        foreach ($levels as $r) :
            $level = $r['level'];
            $id_level = $r['id'];
            $newAr = [];
            foreach ($menus as $val) {
                if ($val['level'] == $id_level) {
                    $newAr[] = $val;
                }
            }
        ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span><?= $level; ?></span>
            </h6>
            <ul class="nav flex-column">
                <?php
                foreach ($newAr as $s) :
                    $menu = $s['menu'];
                    $url = $s['url'];
                ?>
                    <li class="nav-item m-0 p-0">
                        <a class="nav-link pb-1" href="<?=$url; ?>">
                            &nbsp; <?= $menu; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
        <form action="/logout" method="post">
            @csrf
            <button class="btn btn-sm btn-outline-info mt-3 ml-4">Keluar Aplikasi</button>
        </form>
    </div>
</nav>