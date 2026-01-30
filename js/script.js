// Elemen-elemen untuk navigasi
const bookshelvesLink = document.getElementById('bookshelves-link');
const usersListLink = document.getElementById('users-list-link');
const dynamicContent = document.getElementById('dynamic-content');
const userDetails = document.getElementById('user-details');
const bookDetails = document.getElementById('book-details');
const addDataLink = document.getElementById('addData-link');
const addUserForm = document.getElementById('addUserForm');
const addBookForm = document.getElementById('addBookForm');
let currentUser = null; // Variable to store selected user
let currentBook = null; // Variable to store selected book

// Fungsi untuk mengganti konten dinamis
function showContent(content) {
    userDetails.style.display = 'none'; // Sembunyikan user details
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
            console.error('Error fetching barang:', error);
            showContent('<h3>Bookshelves</h3><p>Error loading barang. Please try again later.</p>');
        });

    userDetails.style.display = 'none'; // Sembunyikan user details saat menampilkan bookshelves
    addUserForm.style.display = 'none';
    addBookForm.style.display = 'none';
});

// BOOK DETAIL
function showBookDetails(book) {
    bookDetails.style.display = 'block'; // Tampilkan book details
    userDetails.style.display = 'none'; // Sembunyikan user details

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
        alert('Book data updated successfully!');
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
        <button id="add-user-btn" class="btn btn-info" style="background-color: #F9BF65; color: black;">Add User</button>
    `;

    // Menambahkan event listener untuk tombol "Add Book"
    document.getElementById('add-book-btn').addEventListener('click', function() {
        addBookForm.style.display = 'block'; // Tampilkan formulir penambahan buku
        addUserForm.style.display = 'none'; // Sembunyikan formulir penambahan pengguna
    });

    // Menambahkan event listener untuk tombol "Add User"
    document.getElementById('add-user-btn').addEventListener('click', function() {
        addUserForm.style.display = 'block'; // Tampilkan formulir penambahan pengguna
        addBookForm.style.display = 'none'; // Sembunyikan formulir penambahan buku
    });

    userDetails.style.display = 'none';
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
            alert('Failed to add book: ' + (data.error || 'Unknown error.'));
        }        
    })
    .catch(error => {
        console.error('Error adding book:', error);
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

//-----------------------------------------------//
// Ketika Users List di klik
usersListLink.addEventListener('click', function() {
    // Fetch employee data from your backend 
    fetch('../php/get_users.php') // Pastikan file PHP ini mengambil data dari tabel karyawan
        .then(response => response.json())
        .then(data => {
            const users = data.data;
            if (users.length === 0) {
                showContent('<h3>Users List</h3><p>No employees available.</p>');
                return;
            }

            const usersContent = `
                <h3>Employees List</h3>
                <p style="font-size: 12px;">Klik salah satu baris untuk menampilkan detail karyawan</p>
                <div style="height: 300px; overflow: auto;"> <!-- Set height and enable scrolling -->
                    <table class="table table-bordered" style="background-color: white; color: black;">
                        <thead>
                            <tr>
                                <th>ID Karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Username</th>
                                <th>No. Telp</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${users.map(user => `
                                <tr>
                                    <td style="cursor: pointer;" class="user-row" data-user='${JSON.stringify(user)}'>${user.id_karyawan}</td>
                                    <td style="cursor: pointer;" class="user-row" data-user='${JSON.stringify(user)}'>${user.nama_karyawan}</td>
                                    <td>${user.username_karyawan}</td>
                                    <td>${user.notelp_karyawan}</td>
                                    <td>${user.alamat_karyawan}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                
            `;
            showContent(usersContent);

            // Menambahkan event listener untuk baris tabel pengguna
            document.querySelectorAll('.user-row').forEach(row => {
                row.addEventListener('click', function() {
                    currentUser = JSON.parse(this.getAttribute('data-user')); // Store selected employee
                    showUserDetails(currentUser); // Tampilkan detail karyawan
                });
            });
        })
        .catch(error => {
            console.error('Error fetching employees:', error);
            showContent('<h3>Employees List</h3><p>Error loading employees. Please try again later.</p>');
        });

    bookDetails.style.display = 'none'; // Sembunyikan book details saat menampilkan users list
    addUserForm.style.display = 'none';
    addBookForm.style.display = 'none';
});


// USER DETAIL
function showUserDetails(user) {
    userDetails.style.display = 'block'; // Tampilkan user details
    bookDetails.style.display = 'none'; // Sembunyikan book details

    // Mengisi input dengan data pengguna
    document.getElementById('user-name-input').value = user.nama_karyawan;
    document.getElementById('user-username-input').value = user.username_karyawan;
    document.getElementById('user-telp-input').value = user.notelp_karyawan;
    document.getElementById('user-address-input').value = user.alamat_karyawan;
}

// SAVE - UPDATE USER
document.getElementById('save-user-button').addEventListener('click', function() {
if (currentUser) {
    const updatedUser = {
        id_karyawan: currentUser.id_karyawan,
        nama_karyawan: document.getElementById('user-name-input').value,
        username_karyawan: document.getElementById('user-username-input').value,
        notelp_karyawan: document.getElementById('user-telp-input').value,
        alamat_karyawan: document.getElementById('user-address-input').value
    };

    fetch('../php/update_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedUser)
    })
    .then(response => response.text())
    .then(text => {
        console.log('Raw response:', text); // Mencetak respons mentah
        const data = JSON.parse(text); // Menguraikan respons sebagai JSON
        if (data.success) {
            alert('Employee data updated successfully!');
            window.location.reload();
        } else {
            alert('Failed to update employee data: ' + (data.message || 'Unknown error.'));
        }
    })
    .catch(error => {
        console.error('Error updating employee:', error);
    });
}
});

// ADD USER
document.getElementById('submit-user-button').addEventListener('click', function() {
    const username = document.getElementById('new-username').value;
    const password = document.getElementById('new-password').value;
    const nama_karyawan = document.getElementById('new-nama').value;
    const notelp_karyawan = document.getElementById('new-telp').value;
    const alamat_karyawan = document.getElementById('new-alamat').value;

    const newUser = {
        username_karyawan: username,
        password_karyawan: password,
        nama_karyawan: nama_karyawan,
        notelp_karyawan: notelp_karyawan,
        alamat_karyawan: alamat_karyawan
    };

    fetch('../php/add_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newUser)
    })
    .then(response => response.text())
    .then(data => {
        console.log("Raw response:", data); // Log the raw response
        return JSON.parse(data); // Parse the JSON manually
    })
    .then(data => {
        console.log(data); // Log the parsed response
        if (data.status === 'success') {
            alert('Employee added successfully!');
            window.location.reload();
        } else {
            alert('Failed to add employee: ' + (data.error || 'Unknown error.'));
        }
    })
    .catch(error => {
        console.error('Error adding employee:', error);
    });

});

// DELETE USER
document.getElementById('delete-user-button').addEventListener('click', function() {
    if (currentUser) {
        const updatedUser = {
            id_karyawan: currentUser.id_karyawan,
        };
    
        const confirmDelete = confirm('Are you sure you want to delete this employee? This action cannot be undone.');

        if (confirmDelete) {
            fetch('../php/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedUser)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Employee data deleted successfully!');
                    window.location.reload();
                } else {
                    alert('Failed to delete employee data.');
                }
            })
            .catch(error => {
                console.error('Error deleting employee:', error);
            });
        }
    }
});


//-----------------------------------------------//


