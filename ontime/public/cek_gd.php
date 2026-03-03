php
if (extension_loaded('gd')) {
    echo SELAMAT! Ekstensi GD sudah AKTIF.;
} else {
    echo GAGAL! Ekstensi GD masih BELUM AKTIF.;
    phpinfo();
}