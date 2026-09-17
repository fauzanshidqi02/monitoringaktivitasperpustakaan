<style>
    .app-footer {
        margin-top: 28px;
        padding: 18px 20px;
        text-align: center;
        color: #6b7280;
        font-size: 14px;
        background: #ffffff;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
    }

    .app-footer strong {
        color: #0f766e;
    }

    .footer-main {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .copyright-icon {
        display: inline-flex;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        border: 1px solid #0f766e;
        color: #0f766e;
        font-size: 13px;
        font-weight: bold;
    }

    .footer-time {
        display: block;
        margin-top: 7px;
        font-size: 13px;
        color: #9ca3af;
        line-height: 1.5;
    }

    .footer-time strong {
        color: #2563eb;
        font-weight: bold;
    }

    @media (max-width: 700px) {
        .app-footer {
            font-size: 13px;
            padding: 16px 12px;
        }

        .footer-time {
            font-size: 12px;
        }
    }
</style>

<footer class="app-footer">
    <div class="footer-main">
        <span class="copyright-icon">©</span>
        <span>2026 by <strong>Rumah Literasi</strong></span>
    </div>

    <span class="footer-time" id="footerRealtime">
        Memuat waktu...
    </span>
</footer>

<script>
    (function () {
        const footerTime = document.getElementById('footerRealtime');

        if (!footerTime) {
            return;
        }

        const serverStartTime = new Date("{{ now('Asia/Jakarta')->toIso8601String() }}").getTime();
        const browserStartTime = Date.now();

        const namaHari = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        const namaBulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        function tambahNol(angka) {
            return angka < 10 ? '0' + angka : angka;
        }

        function updateFooterRealtime() {
            const elapsedTime = Date.now() - browserStartTime;
            const currentTime = new Date(serverStartTime + elapsedTime);

            const hari = namaHari[currentTime.getDay()];
            const tanggal = tambahNol(currentTime.getDate());
            const bulan = namaBulan[currentTime.getMonth()];
            const tahun = currentTime.getFullYear();

            const jam = tambahNol(currentTime.getHours());
            const menit = tambahNol(currentTime.getMinutes());
            const detik = tambahNol(currentTime.getSeconds());

            footerTime.innerHTML =
                hari + ', ' +
                tanggal + ' ' +
                bulan + ' ' +
                tahun +
                ' | <strong>' +
                jam + ':' + menit + ':' + detik +
                ' WIB</strong>';
        }

        updateFooterRealtime();
        setInterval(updateFooterRealtime, 1000);
    })();
</script>
