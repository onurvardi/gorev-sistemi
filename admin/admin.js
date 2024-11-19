document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('kullaniciModal');
    const yeniKullaniciBtn = document.getElementById('yeniKullanici');
    const modalClose = document.getElementById('modalClose');

    // Modal aç
    yeniKullaniciBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    // Modal kapat
    modalClose.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Modal dışına tıklayınca kapat
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
