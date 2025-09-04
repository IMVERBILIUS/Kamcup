/**
 * Skrip ini bertanggung jawab untuk mengambil skor pertandingan secara real-time
 * dan memperbarui tampilan HTML di halaman event.
 *
 * Catatan: Skrip ini mengasumsikan adanya elemen-elemen HTML dengan ID berikut:
 * - 'match-status'
 * - 'team1-score'
 * - 'team2-score'
 *
 * serta variabel 'eventId' dari backend Laravel.
 */

document.addEventListener("DOMContentLoaded", function () {
    // Ambil referensi ke elemen-elemen DOM
    const matchStatusElement = document.getElementById("match-status");
    const team1ScoreElement = document.getElementById("team1-score");
    const team2ScoreElement = document.getElementById("team2-score");

    // Asumsi: Variabel eventId sudah ada dari backend Laravel.
    // Contoh: const eventId = {{ $event->id }};
    // Ganti ini dengan cara yang sesuai untuk mendapatkan ID event di proyek Anda.
    const eventId =
        typeof eventId !== "undefined" ? eventId : "placeholder_event_id";

    /**
     * Mengambil data skor pertandingan dari API dan memperbarui tampilan.
     */
    async function fetchLiveScore() {
        if (!matchStatusElement || !team1ScoreElement || !team2ScoreElement) {
            console.warn(
                "Elemen HTML untuk live score tidak ditemukan. Pembaruan dibatalkan."
            );
            return;
        }

        try {
            // Lakukan permintaan GET ke endpoint API
            const response = await fetch(`/api/matches/${eventId}/score`);

            // Periksa apakah respons berhasil
            if (!response.ok) {
                // Jika respons tidak OK (misalnya status 404), lempar error
                throw new Error("Gagal mengambil data live score.");
            }

            // Parse respons sebagai JSON
            const data = await response.json();

            // Perbarui teks di elemen HTML dengan data baru
            matchStatusElement.textContent = data.status.toUpperCase();
            team1ScoreElement.textContent = data.team1_score;
            team2ScoreElement.textContent = data.team2_score;
        } catch (error) {
            // Tangani error jika terjadi masalah pada fetch
            console.error("Error saat mengambil live score:", error);
            // Anda bisa menambahkan logika untuk menampilkan pesan error kepada pengguna di sini
        }
    }

    // Panggil fungsi segera setelah halaman dimuat untuk tampilan awal
    fetchLiveScore();

    // Atur interval untuk memanggil fungsi setiap 5 detik (5000ms)
    setInterval(fetchLiveScore, 5000);
});
