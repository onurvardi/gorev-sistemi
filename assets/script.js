function yeniBasvuru() {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <h3>Yeni Başvuru</h3>
            <form id="basvuruForm">
                <div class="form-row">
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input type="text" name="ad_soyad" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="tel" name="telefon" required class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Sokak No</label>
                        <input type="text" name="sokak_no" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Bina No</label>
                        <input type="text" name="bina_no" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Daire No</label>
                        <input type="text" name="daire_no" required class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Öncelik</label>
                    <select name="oncelik" required class="form-control">
                        <option value="Normal">Normal</option>
                        <option value="Acil">Acil</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Kaydet</button>
                <button type="button" class="btn-iptal" onclick="this.closest('.modal').remove()">İptal</button>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'flex';

    document.getElementById('basvuruForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('basvuru-ekle.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showNotification('Başvuru kaydedildi');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            showNotification('Bir hata oluştu!', 'error');
        });
    });
}

function basvuruDetay(id) {
    const modal = document.createElement('div');
    modal.className = 'modal';
    
    fetch(`basvuru-detay.php?id=${id}&modal=1`)
        .then(response => response.text())
        .then(html => {
            modal.innerHTML = `
                <div class="modal-content">
                    ${html}
                    <button class="btn-iptal" onclick="this.closest('.modal').remove()">Kapat</button>
                </div>
            `;
            document.body.appendChild(modal);
            modal.style.display = 'flex';
        });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.add('show'), 100);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function ekipAta(basvuruId, ekipId) {
    fetch('islem.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            islem: 'ekip_ata',
            id: basvuruId,
            ekip_id: ekipId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification('Ekip ataması yapıldı');
            setTimeout(() => location.reload(), 1000);
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        showNotification('Bir hata oluştu!', 'error');
    });
}
