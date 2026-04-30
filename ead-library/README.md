## Skenario Uji Dusk - EAD Library

Skenario pengujian end-to-end berbasis Laravel Dusk untuk aplikasi CRUD buku dengan autentikasi.

### Prasyarat

1. Database testing siap digunakan.
2. Browser driver untuk Dusk sudah dikonfigurasi.
3. Jalankan migration dan seed jika dibutuhkan.
4. Jalankan test dari root project.

### Daftar Skenario

> Konvensi notasi: nama field merujuk ke atribut `name` HTML (contoh `name="password_confirmation"`), tombol/link ditulis sesuai teks yang tampil, dan elemen non-teks pakai selector CSS / `aria-label`.

| No | Skenario | Tujuan | Langkah | Ekspektasi |
| --- | --- | --- | --- | --- |
| 1 | Registrasi Berhasil | Memastikan user baru bisa register dan diarahkan ke dashboard buku. | 1. Buka `/register`.<br>2. Isi input `name`, `email`, `password`, `password_confirmation`.<br>3. Klik tombol `Register`. | 1. Path saat ini `/books`.<br>2. Muncul `Registrasi berhasil.`.<br>3. Halaman menampilkan `Daftar Buku`. |
| 2 | Login Berhasil | Memastikan user terdaftar bisa login. | 1. Buka `/login`.<br>2. Isi input `email`, `password`.<br>3. Klik tombol `Login`. | 1. Path saat ini `/books`.<br>2. Muncul `Login berhasil.`.<br>3. Halaman menampilkan `Daftar Buku`. |
| 3 | Tambah Buku Berhasil | Memastikan alur create data buku berjalan. | 1. Siapkan user via `User::factory()` dan login dengan helper `loginAs($user)`.<br>2. Buka `/books`, klik link `Tambah Buku`.<br>3. Isi input `title`, `author`, pilih `category`, isi `published_year`, `stock`, `summary`.<br>4. Klik tombol `Simpan Buku`. | 1. Data buku tersimpan.<br>2. Muncul `Buku berhasil ditambahkan.`.<br>3. Nilai `title` terlihat pada halaman hasil. |
| 4 | Lihat Detail Buku | Memastikan halaman detail bisa diakses melalui navigasi UI. | 1. Siapkan user via `User::factory()` dan login dengan helper `loginAs($user)`.<br>2. Buka `/books`, klik link `Tambah Buku`, isi form lalu klik tombol `Simpan Buku`.<br>3. Klik link `Kembali`.<br>4. Klik link `Detail` pada baris buku. | 1. Nilai `title` tampil pada halaman detail.<br>2. Nilai `author` tampil pada halaman detail. |
| 5 | Update Buku - Penulis Mengandung Angka (Negatif) | Memvalidasi form update menolak nama penulis yang mengandung angka. | 1. Siapkan user via `User::factory()` dan login dengan helper `loginAs($user)`.<br>2. Buka `/books`, klik link `Tambah Buku`, isi form (input `author` tanpa angka) lalu klik tombol `Simpan Buku`.<br>3. Klik link `Edit Buku` pada halaman detail.<br>4. Ubah input `author` menjadi nilai yang mengandung angka (misal `Penulis 123`).<br>5. Klik tombol `Perbarui Buku`. | 1. Validasi gagal sehingga update tidak diproses.<br>2. Muncul pesan error `Penulis tidak boleh mengandung angka.`.<br>3. Data tidak berubah (nilai `author` lama tetap muncul di tabel `/books`, nilai baru bernilai angka tidak muncul). |
| 6 | Hapus Buku Berhasil | Memastikan alur delete dengan konfirmasi berjalan. | 1. Siapkan user via `User::factory()` dan login dengan helper `loginAs($user)`.<br>2. Buka `/books`, klik link `Tambah Buku`, isi form lalu klik tombol `Simpan Buku`.<br>3. Klik link `Kembali`.<br>4. Klik elemen `button[aria-label='Hapus buku']` pada baris buku.<br>5. Terima dialog konfirmasi (`acceptDialog`). | 1. Muncul `Buku berhasil dihapus.`.<br>2. Nilai `title` tidak tampil lagi di tabel. |
| 7 | Logout Berhasil | Memastikan user bisa logout setelah login. | 1. Siapkan user via `User::factory()` dan login dengan helper `loginAs($user)`, lalu buka `/books`.<br>2. Klik elemen `.user-icon-btn` pada navbar.<br>3. Klik tombol `Logout`. | 1. Redirect ke `/login`.<br>2. Muncul `Logout berhasil.`. |

### Test Scenarios (English)

> Notation: form-field names refer to the HTML `name` attribute (e.g. `name="password_confirmation"`), buttons/links use their visible text, and non-text elements use a CSS / `aria-label` selector.

| No | Scenario | Objective | Steps | Expectations |
| --- | --- | --- | --- | --- |
| 1 | Successful Registration | Ensure a new user can register and is redirected to the books dashboard. | 1. Open `/register`.<br>2. Fill the `name`, `email`, `password`, `password_confirmation` inputs.<br>3. Click the `Register` button. | 1. Current path is `/books`.<br>2. Message `Registrasi berhasil.` appears.<br>3. The page displays `Daftar Buku`. |
| 2 | Successful Login | Ensure a registered user can log in. | 1. Open `/login`.<br>2. Fill the `email`, `password` inputs.<br>3. Click the `Login` button. | 1. Current path is `/books`.<br>2. Message `Login berhasil.` appears.<br>3. The page displays `Daftar Buku`. |
| 3 | Successful Add Book | Ensure the book creation flow works. | 1. Prepare a user via `User::factory()` and log in using the `loginAs($user)` helper.<br>2. Open `/books`, click the `Tambah Buku` link.<br>3. Fill the `title`, `author` inputs, select `category`, fill `published_year`, `stock`, `summary`.<br>4. Click the `Simpan Buku` button. | 1. Book data is saved.<br>2. Message `Buku berhasil ditambahkan.` appears.<br>3. The `title` value is visible on the result page. |
| 4 | View Book Detail | Ensure the detail page can be accessed through UI navigation. | 1. Prepare a user via `User::factory()` and log in using the `loginAs($user)` helper.<br>2. Open `/books`, click the `Tambah Buku` link, fill the form, and click the `Simpan Buku` button.<br>3. Click the `Kembali` link.<br>4. Click the `Detail` link on the target row. | 1. The `title` value appears on the detail page.<br>2. The `author` value appears on the detail page. |
| 5 | Update Book - Author Containing Digits (Negative) | Validate that the update form rejects author names containing digits. | 1. Prepare a user via `User::factory()` and log in using the `loginAs($user)` helper.<br>2. Open `/books`, click the `Tambah Buku` link, fill the form (`author` without digits), and click the `Simpan Buku` button.<br>3. Click the `Edit Buku` link on the detail page.<br>4. Change the `author` input to a value containing digits (e.g. `Penulis 123`).<br>5. Click the `Perbarui Buku` button. | 1. Validation fails so the update is not processed.<br>2. Error message `Penulis tidak boleh mengandung angka.` appears.<br>3. Book data is unchanged (the old `author` still appears in the `/books` table, the new digit-containing value does not appear). |
| 6 | Successful Delete Book | Ensure the delete flow with confirmation works. | 1. Prepare a user via `User::factory()` and log in using the `loginAs($user)` helper.<br>2. Open `/books`, click the `Tambah Buku` link, fill the form, and click the `Simpan Buku` button.<br>3. Click the `Kembali` link.<br>4. Click the `button[aria-label='Hapus buku']` element on the book row.<br>5. Accept the confirmation dialog (`acceptDialog`). | 1. Message `Buku berhasil dihapus.` appears.<br>2. The `title` value no longer appears in the table. |
| 7 | Successful Logout | Ensure a user can log out after logging in. | 1. Prepare a user via `User::factory()` and log in using the `loginAs($user)` helper, then open `/books`.<br>2. Click the `.user-icon-btn` element in the navbar.<br>3. Click the `Logout` button. | 1. Redirected to `/login`.<br>2. Message `Logout berhasil.` appears. |

> Note: flash messages (`Registrasi berhasil.`, `Login berhasil.`, etc.) are kept in Indonesian because they are the literal strings shown in the UI and asserted by the test cases.

> Catatan: hanya skenario 1 (Registrasi) dan 2 (Login) yang melakukan login melalui form UI — keduanya memang menguji flow tersebut. Skenario 3–7 mempersiapkan user lewat `User::factory()` dan masuk dengan helper Dusk `loginAs($user)` agar fokus uji tetap pada fitur yang relevan.
>
> Note: only scenarios 1 (Registration) and 2 (Login) sign in through the UI form — those flows are exactly what the tests are verifying. Scenarios 3–7 prepare a user via `User::factory()` and authenticate with the Dusk `loginAs($user)` helper so each test stays focused on the feature under test.

### Perintah Eksekusi

Menjalankan satu skenario tertentu:

```bash
php artisan dusk --filter=Test
```

Menjalankan seluruh skenario Dusk:

```bash
php artisan dusk
```
