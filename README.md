# finalcbr-kel10

# Endpoint

**URL:** .../Api

## Metode

- **GET:** Mengambil data dari tabel database.
- **POST:** Menghitung hasil Sørensen–Dice coefficient berdasarkan parameter yang diberikan.

## Operasi GET

### Tanpa Parameter

Melakukan GET Request tanpa parameter akan langsung mendapatkan output semua data yang ada di masing - masing tabel database

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

**Fungsi:** Langsung menghitung koefisien Sørensen–Dice coefficient berdasarkan parameter yang diberikan pada saat POST Request dikirim.
