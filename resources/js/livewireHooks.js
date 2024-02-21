document.addEventListener('livewire:load', function () {
    Livewire.hook('component.initialized', () => {
        // Ketika komponen Livewire diinisialisasi
        Livewire.on('stockSelected', (stockId) => {
            // Tanggapi perubahan dalam pilihan stok
            if (stockId) {
                // Jika stok dipilih, perbarui nilai input dengan stok gudang yang sesuai
                document.getElementById('gudang_input').value = stockId;
            }
        });
    });
});
