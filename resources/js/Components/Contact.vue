<script setup>
defineProps({
    settings: Object
});
</script>

<template>
    <section id="kontak">
        <div>
            <p class="section-tag reveal">Hubungi Kami</p>
            <h2 class="section-title reveal reveal-delay-1">Kantor Desa<br><em>Siap Melayani</em></h2>
            <p class="section-body reveal reveal-delay-2">Kami terbuka untuk pertanyaan, kunjungan, dan kerjasama. Perangkat desa siap melayani dengan sepenuh hati.</p>
            <div class="kontak-card reveal reveal-delay-3">
                <div class="kontak-detail">
                    <div class="kontak-row">
                        <div class="kontak-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div><p class="kontak-label">Alamat</p><p class="kontak-val">{{ settings.address }}</p></div>
                    </div>
                    <div class="kontak-row">
                        <div class="kontak-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div><p class="kontak-label">Telepon</p><p class="kontak-val">{{ settings.phone }}</p></div>
                    </div>
                    <div class="kontak-row">
                        <div class="kontak-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div><p class="kontak-label">Email</p><p class="kontak-val">{{ settings.email }}</p></div>
                    </div>
                    <div class="kontak-row">
                        <div class="kontak-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div><p class="kontak-label">Jam Layanan</p><p class="kontak-val">{{ settings.working_hours }}</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal reveal-delay-2">
            <p class="section-tag">Kirim Pesan</p>
            <h3 class="kontak-subtitle">Ada yang ingin ditanyakan?</h3>
            <p class="kontak-hint">Tim kami akan merespons dalam 1×24 jam kerja.</p>
            <form class="form-wrap">
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Nama Lengkap</label><input type="text" class="form-control" placeholder="Nama Anda"></div>
                    <div class="form-group"><label class="form-label">No. HP / Email</label><input type="text" class="form-control" placeholder="08xx atau email@contoh.com"></div>
                </div>
                <div class="form-group"><label class="form-label">Keperluan</label><select class="form-control"><option>Informasi Umum</option><option>Layanan Administrasi</option><option>Pengaduan</option><option>Kerjasama / Investasi</option><option>Pariwisata</option></select></div>
                <div class="form-group"><label class="form-label">Pesan</label><textarea class="form-control" placeholder="Tuliskan pesan atau pertanyaan Anda..."></textarea></div>
                <button type="submit" class="submit-btn"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg> Kirim Pesan</button>
            </form>
        </div>
    </section>
</template>
