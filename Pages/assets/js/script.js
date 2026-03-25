/**
 * Logika Dropdown dengan Delay 2 Detik
 * Mengontrol kemunculan menu profil pada INFO_KRL_WEB
 */

document.addEventListener('DOMContentLoaded', () => {
    const dropdownWrapper = document.querySelector('.profile-dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');
    let timeoutId;

    // Pastikan elemen ada di halaman sebelum menjalankan logika
    if (dropdownWrapper && dropdownContent) {
        
        // 1. Saat Mouse MASUK ke area dropdown
        dropdownWrapper.addEventListener('mouseenter', () => {
            // Batalkan perintah tutup jika mouse masuk kembali sebelum 2 detik
            clearTimeout(timeoutId);
            dropdownContent.classList.add('active');
        });

        // 2. Saat Mouse KELUAR dari area dropdown
        dropdownWrapper.addEventListener('mouseleave', () => {
            // Mulai hitung mundur 2000ms (2 detik) sebelum menutup menu
            timeoutId = setTimeout(() => {
                dropdownContent.classList.remove('active');
            }, 2000); 
        });

        // Tambahan: Tutup dropdown jika mengklik area lain di luar menu
        window.addEventListener('click', (e) => {
            if (!dropdownWrapper.contains(e.target)) {
                dropdownContent.classList.remove('active');
            }
        });
    }
});