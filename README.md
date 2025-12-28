# 🛒 TJ&T Mart – Website E-Commerce Asrama

TJ&T Mart adalah website **e-commerce berbasis web** yang dikembangkan untuk memenuhi kebutuhan harian **penghuni asrama mahasiswa**. Sistem ini menyediakan layanan pembelian produk kebutuhan sehari-hari, token listrik, dan galon asrama dengan alur pemesanan yang terintegrasi, aman, dan mudah digunakan.

Website ini dikembangkan menggunakan **Laravel Framework** sebagai bagian dari proyek pengembangan aplikasi web.



 🎯 Tujuan Pengembangan

- Menyediakan platform belanja khusus lingkungan asrama
- Mempermudah pemesanan kebutuhan harian mahasiswa
- Mengintegrasikan layanan **token listrik** dan **galon asrama**
- Menyediakan sistem transaksi dan notifikasi yang terstruktur


⚠️ Asumsi & Batasan Sistem

- Saat **login pertama**, pengguna diminta memilih:
  - **Penghuni asrama**
  - **Non-penghuni asrama**
- Jika pengguna adalah **penghuni asrama**, maka:
  - Wajib mengisi **Gedung Asrama & Nomor Kamar**
  - Data ini digunakan untuk fitur **Galon Asrama** dan **Token Listrik**
- Jika pengguna **bukan penghuni asrama**:
  - Tidak diwajibkan mengisi alamat
  - Pengiriman **dibatasi hanya untuk penghuni asrama**
  - Beberapa fitur akan dinonaktifkan (token & galon)
- Website ini **dibatasi untuk area asrama** (bukan layanan publik umum)


👥 Role Pengguna

🔑 Super Admin
- Pengelolaan sistem secara keseluruhan (konseptual)

🛠️ Admin
- Dashboard admin
- Manajemen produk & transaksi

👤 User
- Pengguna akhir (penghuni asrama / non-asrama)


🌐 Fitur & Halaman Website

🏠 Beranda / Home Page
- Dapat diakses tanpa login
- Banner promo & pengumuman
- Product grid dengan informasi stok
- Produk habis ditampilkan abu-abu
- Header dengan:
  - Search & filter kategori
  - Wishlist (dengan counter)
  - Cart (dengan counter)
  - Notifikasi
  - Login / Register / Profile dropdown

 📦 Product Detail Page
- Dapat diakses tanpa login
- Breadcrumb (Home > Kategori > Produk)
- Informasi lengkap produk:
  - Harga, stok, lokasi
  - Rating & ulasan
  - Variasi produk
- Tombol:
  - Add to Cart
  - Wishlist
- Rekomendasi produk serupa

 🛒 Cart Page
- Hanya bisa diakses setelah login
- Redirect ke login jika belum login
- Informasi:
  - Daftar produk
  - Kuantitas (plus/minus)
  - Subtotal per produk
- Ringkasan pesanan:
  - Subtotal
  - Diskon
  - Ongkir
  - Total
- Tombol lanjut ke checkout


 ❤️ Wishlist Page
- Hanya untuk user login
- Menampilkan produk favorit
- Aksi:
  - Add to Cart
  - Remove
  - Select multiple item
- Notifikasi jika wishlist kosong

👤 Profile Page
- Sidebar navigasi akun:
  - Profil Saya (CRUD)
  - Alamat Pengiriman
  - Riwayat Pesanan
  - Metode Pembayaran
  - Ubah Password
  - Logout


🔔 Notifikasi Page
- Hanya untuk user login
- Filter:
  - Semua
  - Belum Dibaca
  - Sudah Dibaca
- Aksi:
  - Tandai dibaca
  - Hapus
  - Detail transaksi
- Notifikasi muncul untuk:
  - Status pesanan
  - Perubahan akun
  - Promo
  - Maintenance sistem


⚡ Token Listrik Page
- Khusus penghuni asrama
- Nominal tetap (20k – 1jt)
- Metode pembayaran
- Menampilkan hasil token
- Riwayat transaksi token


🚰 Galon Asrama Page
- Penghuni dapat:
  - Membeli galon baru
  - Isi ulang galon
  - Galon sekali pakai
- Opsi:
  - Antar ke kamar
  - Ambil sendiri
- Riwayat pembelian galon
- Status kepemilikan galon


💳 Checkout & Pembayaran
- Checkout hanya untuk user login
- Opsi:
  - Delivery
  - Takeaway
- Metode pembayaran:
  - QRIS
  - E-Wallet
  - M-Banking
  - COD
- Ringkasan pembayaran & konfirmasi


✅ Order Success / Bukti Transaksi
- Bukti transaksi untuk kasir (takeaway)
- Estimasi pengiriman
- Detail pesanan lengkap
- Tombol kembali ke beranda


🛠️ Teknologi yang Digunakan

- **Framework** : Laravel
- **Frontend** : Blade Template, Tailwind CSS
- **Backend** : PHP
- **Database** : MySQL
- **Version Control** : Git & GitHub


👥 Tim Tubes Pbw

| Nama | Tanggung Jawab |

| **AwanWush** | Integrasi & kontribusi utama |
| **Rhafhy** | Home Page & Product Detail |
| **Damar** | Cart, Wishlist, Notifikasi |
| **Fadhil** | Profile & Order Success |
| **Raffif** | Token Listrik & Galon Asrama |
| **Anri** | Checkout & Pembayaran |




✨ **TJ&T Mart – Solusi kebutuhan asramamu.**
