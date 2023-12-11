# finalcbr-kel10

# Endpoint

**URL:** .../Api

## Metode

- **GET:** Mengambil data dari tabel database.
- **POST:** Menghitung hasil Sørensen–Dice coefficient berdasarkan parameter yang diberikan.

## Operasi GET

### Tanpa Parameter

Jika melakukan GET request tanpa parameter, itu akan mengembalikan semua data dari tabel-tabel tertentu dalam database.

### Parameter GET yang Didukung

Params yang disebutkan dalam GET request:

- siswa
- pernyataan
- minat_bakat
- kasus
- base_case
- pernyataan_siswa

## Operasi POST

### Parameter

- umur
- jenis_kelamin
- kelas
- id_pernyataan = []

### Deskripsi Operasi POST

**Fungsi:** Langsung menghitung koefisien Sørensen–Dice coefficient berdasarkan parameter yang diberikan pada saat POST request.
