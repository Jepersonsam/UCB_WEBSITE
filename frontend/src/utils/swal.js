import Swal from 'sweetalert2';
export const swal = {
    success: (message, title = 'Berhasil!') => {
        return Swal.fire({
            icon: 'success',
            title,
            text: message,
            confirmButtonColor: '#0ea5e9',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true,
        });
    },
    error: (message, title = 'Terjadi Kesalahan!') => {
        return Swal.fire({
            icon: 'error',
            title,
            text: message,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'OK',
        });
    },
    warning: (message, title = 'Peringatan!') => {
        return Swal.fire({
            icon: 'warning',
            title,
            text: message,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'OK',
        });
    },
    info: (message, title = 'Informasi') => {
        return Swal.fire({
            icon: 'info',
            title,
            text: message,
            confirmButtonColor: '#0ea5e9',
            confirmButtonText: 'OK',
        });
    },
    confirm: (message, title = 'Konfirmasi', confirmText = 'Ya, Hapus!', cancelText = 'Batal') => {
        return Swal.fire({
            icon: 'warning',
            title,
            text: message,
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            reverseButtons: true,
        });
    },
    confirmDelete: (itemName = 'item ini') => {
        return Swal.fire({
            icon: 'warning',
            title: 'Hapus?',
            text: `Apakah Anda yakin ingin menghapus ${itemName}?`,
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        });
    },
};
export default swal;
