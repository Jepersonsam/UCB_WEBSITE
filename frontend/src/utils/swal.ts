import Swal from 'sweetalert2'

export const swal = {
  success: (message: string, title: string = 'Berhasil!') => {
    return Swal.fire({
      icon: 'success',
      title,
      text: message,
      confirmButtonColor: '#0ea5e9',
      confirmButtonText: 'OK',
      timer: 3000,
      timerProgressBar: true,
    })
  },

  error: (message: string, title: string = 'Terjadi Kesalahan!') => {
    return Swal.fire({
      icon: 'error',
      title,
      text: message,
      confirmButtonColor: '#ef4444',
      confirmButtonText: 'OK',
    })
  },

  warning: (message: string, title: string = 'Peringatan!') => {
    return Swal.fire({
      icon: 'warning',
      title,
      text: message,
      confirmButtonColor: '#f59e0b',
      confirmButtonText: 'OK',
    })
  },

  info: (message: string, title: string = 'Informasi') => {
    return Swal.fire({
      icon: 'info',
      title,
      text: message,
      confirmButtonColor: '#0ea5e9',
      confirmButtonText: 'OK',
    })
  },

  confirm: (message: string, title: string = 'Konfirmasi', confirmText: string = 'Ya, Hapus!', cancelText: string = 'Batal') => {
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
    })
  },

  confirmDelete: (itemName: string = 'item ini') => {
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
    })
  },
}

export default swal


