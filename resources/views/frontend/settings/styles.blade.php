<style>
.main-content {
    margin-left: 78px;
    transition: all 0.5s ease;
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* saat sidebar terbuka */
.sidebar.open ~ .main-content {
    margin-left: 250px;
}

/* Card title */
.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #11101D;
}

/* ===== Form Styling =====

/* ===== Form Styling ===== */

.form-container label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #11101D;
}

.form-container .form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.6rem 0.75rem;
    transition: all 0.2s ease;
}

.form-container .form-control:focus {
    border-color: #11101D;
    box-shadow: 0 0 0 0.2rem rgba(17,16,29,0.1);
}



/* ===== Button Styling ===== */
/* Tombol utama (Save Changes) */
.btn-primary {
    background-color: #1e4356 !important;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #68a4c4 !important; /* Warna hover */
}

/* Tombol sekunder / Cancel */
.btn-secondary {
    background-color: #646666;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
}

/* Hover effect */
.btn-secondary:hover {
    background-color: #363636 !important;
    color: #fff !important; /* pastikan teks tetap putih */
}


.btn-link {
    background: #1e4356;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    font-family: 'Poppins', sans-serif;
    transition: background-color 0.3s ease;
}

.btn-link:hover {
    background: #68a4c4; /* Warna hover */
    color: #fff; /* pastikan teks tetap putih */
}
</style>
