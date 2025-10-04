function filterProducts() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const categorySelect = document.getElementById('categorySelect').value;
    const rows = document.querySelectorAll('#productosTable tbody tr');

    rows.forEach(row => {
        const productName = (row.getAttribute('data-nombre') || "").toLowerCase();
        const productId = row.getAttribute('data-id') || "";
        const productCategory = row.getAttribute('data-categoria') || "";

        const matchesSearch = searchInput === "" || productName.includes(searchInput) || productId.includes(searchInput);
        const matchesCategory = categorySelect === "" || productCategory === categorySelect;

        row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
    });
}

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `notification ${type}`;
    notification.style.display = 'block';

    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}
