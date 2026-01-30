// Elemen-elemen untuk navigasi
const bookshelvesLink = document.getElementById('bookshelves-link');
const dynamicContent = document.getElementById('dynamic-content');
const bookDetails = document.getElementById('book-details');
const addDataLink = document.getElementById('addData-link');
const addBookForm = document.getElementById('addBookForm');
let currentBook = null; // Variable to store selected book

// Fungsi untuk mengganti konten dinamis
function showContent(content) {
    bookDetails.style.display = 'none'; // Sembunyikan book details
    dynamicContent.innerHTML = content; // Ganti konten
}

// Ketika Bookshelves di klik
bookshelvesLink.addEventListener('click', function() {
    // Fetch books data from your backend 
    fetch('../php/get_books.php')
        .then(response => response.json())
        .then(data => {
            const books = data.data;
            if (books.length === 0) {
                showContent('<h3>Bookshelves</h3><p>No barang available.</p>');
                return;
            }

            const booksContent = `
                <h3>Inventory</h3>
                <p style="font-size: 12px;">Klik salah satu baris untuk menampilkan detail barang</p>
                <div style="height: 300px; overflow: auto;"> <!-- Set height and enable scrolling -->
                    <table class="table table-bordered" style="background-color: white; color: black;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${books.map(book => `
                                <tr>
                                    <td style="cursor: pointer;" class="book-row" data-book='${JSON.stringify(book)}'>${book.id}</td>
                                    <td style="cursor: pointer;" class="book-row" data-book='${JSON.stringify(book)}'>${book.judul}</td>
                                    <td>${book.stok}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            showContent(booksContent);

            // Menambahkan event listener untuk baris tabel buku
            document.querySelectorAll('.book-row').forEach(row => {
                row.addEventListener('click', function() {
                    currentBook = JSON.parse(this.getAttribute('data-book')); // Store selected book
                    showBookDetails(currentBook); // Tampilkan detail buku
                });
            });
        })
        .catch(error => {
            console.error('Error fetching books:', error);
            showContent('<h3>Bookshelves</h3><p>Error loading barang. Please try again later.</p>');
        });

    addBookForm.style.display = 'none';
});

// BOOK DETAIL
function showBookDetails(book) {
    bookDetails.style.display = 'block'; // Tampilkan book details

    // Mengisi input dengan data buku
    document.getElementById('book-title-input').value = book.judul;
    document.getElementById('book-stock-input').value = book.stok;
}

// SAVE - UPDATE BUKU
document.getElementById('save-book-button').addEventListener('click', function() {
if (currentBook) {
const updatedBook = {
    id: currentBook.id,
    judul: document.getElementById('book-title-input').value,
    stok: document.getElementById('book-stock-input').value
};

fetch('../php/update_book.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(updatedBook)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Barang data updated successfully!');
        window.location.reload();
    } else {
        alert('Failed to update barang data.');
    }
})
.catch(error => {
    console.error('Error updating barang:', error);
});
}
});

// Inisialisasi tampilan awal
bookshelvesLink.click(); // Tampilkan Bookshelves secara default saat halaman dimuat


// ADD DATA
addDataLink.addEventListener('click', function() {
    // Tampilkan tombol untuk menambah buku dan pengguna
    dynamicContent.innerHTML = `
        <h3>Add Data</h3>
        <p style="font-size: 15px;">Klik salah satu tombol untuk menambahkan data baru</p>
        <button id="add-book-btn" class="btn btn-success" style="background-color: #3D4B64; color: white;">Add Barang</button>
    `;

    // Menambahkan event listener untuk tombol "Add Book"
    document.getElementById('add-book-btn').addEventListener('click', function() {
        addBookForm.style.display = 'block'; // Tampilkan formulir penambahan buku
        bookDetails.style.display = 'none';
    });

    bookDetails.style.display = 'none';
});

// ADD BOOK
document.getElementById('submit-book-button').addEventListener('click', function() {
    const newBook = {
        judul: document.getElementById('new-book-title').value,
        stok: document.getElementById('new-book-stock').value
    };

    fetch('../php/add_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newBook)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            alert('Barang added successfully!');
            window.location.reload();
        } else {
            alert('Failed to add barang: ' + (data.error || 'Unknown error.'));
        }        
    })
    .catch(error => {
        console.error('Error adding barang:', error);
    });
});

// DELETE BOOK
document.getElementById('delete-book-button').addEventListener('click', function() {
    if (currentBook) {
    const updatedBook = {
        id: currentBook.id,
    };
    
    // Show confirmation popup
    const confirmDelete = confirm('Are you sure you want to delete this barang? This action cannot be undone.');
    
    if(confirmDelete){
        fetch('../php/delete_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedBook)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Barang data deleted successfully!');
                window.location.reload();
            } else {
                alert('Failed to delete barang data.');
            }
        })
        .catch(error => {
            console.error('Error updating barang:', error);
        });
    }
    }
});
