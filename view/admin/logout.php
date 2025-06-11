<?php
session_start();

if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    session_destroy();
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Logout!',
            text: 'Sampai jumpa lagi!',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '../../login_admin.php';
        });
    </script>";
    exit();
}
?>
