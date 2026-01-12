// ✅ Script.js — aman & hanya aktif di halaman index surat
console.log("Script.js berhasil dimuat ✅");

document.addEventListener("DOMContentLoaded", () => {
    // Cek apakah sedang di halaman index surat (bukan create/edit)
    const path = window.location.pathname;
    if (!path.match(/\/surat$/) && !path.match(/^\/$/)) {
        console.log("Bukan halaman index surat, script.js tidak dijalankan 🚫");
        return;
    }

    // Ambil form filter di dashboard surat masuk
    const form = document.querySelector('form[action*="surat"]');
    if (!form) return;

    const searchInput = form.querySelector("#search-input");
    const statusSelect = form.querySelector('select[name="status"]');
    let timer = null;

    // Elemen loading kecil di kanan atas form
    const loading = document.createElement("div");
    loading.textContent = "⏳ Memuat...";
    loading.className =
        "text-sm text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 hidden";
    form.style.position = "relative";
    form.appendChild(loading);

    function showLoading() {
        loading.classList.remove("hidden");
    }

    function hideLoading() {
        setTimeout(() => loading.classList.add("hidden"), 600);
    }

    // 🔍 Auto-submit saat mengetik di pencarian (setelah 600ms berhenti)
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                showLoading();
                form.submit();
            }, 600);
        });
    }

    // 🔄 Auto-submit saat memilih filter status
    if (statusSelect) {
        statusSelect.addEventListener("change", function () {
            showLoading();
            form.submit();
        });
    }

    console.log(
        "Filter otomatis & pencarian aktif di Dashboard Surat Masuk 🚀"
    );
});
