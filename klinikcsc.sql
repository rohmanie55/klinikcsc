-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13 Jun 2019 pada 04.46
-- Versi Server: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `klinikcsc`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE IF NOT EXISTS `dokter` (
  `kd_dokter` char(4) NOT NULL,
  `nm_dokter` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `sip` varchar(20) NOT NULL,
  `spesialisasi` varchar(100) NOT NULL,
  `bagi_hasil` int(4) NOT NULL,
  PRIMARY KEY (`kd_dokter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`kd_dokter`, `nm_dokter`, `jns_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telepon`, `sip`, `spesialisasi`, `bagi_hasil`) VALUES
('D002', 'dr. Sulis Tiyowati', 'Laki-laki', 'Yogyakarta', '1975-01-12', 'Jl. Condong Catur, Yogyakarta', '081971717171', '1001010101010', 'Umum', 10),
('D005', 'Anis Ade Linis, S.KG', 'Perempuan', 'Way Jepara', '1987-04-16', 'Jl. Pramuka, Labuhan Ratu 1, Way Jepara, Lampung Timur', '08192234456322', '29289282882828', 'Gigi', 10),
('D006', 'dr. Ineke Winda F . SH,MH Kes, SpKK', 'Perempuan', 'Klaten', '1976-10-26', 'Perum tropicana jl.tropika XV no 40 ', '08112236393', '1010101010', 'Kulit', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE IF NOT EXISTS `obat` (
  `kd_obat` char(5) NOT NULL,
  `nm_obat` varchar(100) NOT NULL,
  `harga_modal` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `gambar` varchar(1000) NOT NULL,
  PRIMARY KEY (`kd_obat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`kd_obat`, `nm_obat`, `harga_modal`, `harga_jual`, `stok`, `keterangan`, `gambar`) VALUES
('H0005', 'Bio Skin Car', 10000, 15000, 32, 'Skin car', ''),
('H0009', 'Cream Jerawat Anisa Dark Spot', 55000, 85000, 9, 'untuk jerawat', ''),
('H0012', 'ACNE GEL', 100000, 80000, 15, 'CREAM ACNE GEL', 'assets/img/aura-beauty_aura-beauty-cream-kecantikan-wajah-paket-complete-plus-serum-whitening-15ml_full06.jpg'),
('H0011', 'ACD', 100000, 150000, 15, 'CREAM ACD', 'assets/img/IMG-20180814-WA0004.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE IF NOT EXISTS `pasien` (
  `nomor_rm` char(6) NOT NULL,
  `nm_pasien` varchar(100) NOT NULL,
  `no_identitas` varchar(40) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `gol_darah` enum('A','B','AB','O') NOT NULL,
  `agama` varchar(30) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `stts_nikah` enum('Menikah','Belum Nikah') NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `keluarga_status` enum('Ayah','Ibu','Suami','Istri','Saudara') NOT NULL,
  `keluarga_nama` varchar(100) NOT NULL,
  `keluarga_telepon` varchar(20) NOT NULL,
  `tgl_rekam` date NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`nomor_rm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`nomor_rm`, `nm_pasien`, `no_identitas`, `jns_kelamin`, `gol_darah`, `agama`, `tempat_lahir`, `tanggal_lahir`, `no_telepon`, `alamat`, `stts_nikah`, `pekerjaan`, `keluarga_status`, `keluarga_nama`, `keluarga_telepon`, `tgl_rekam`, `kd_petugas`) VALUES
('RM0013', 'Muzukashi', '7326478324', 'Laki-laki', 'A', 'Islam', 'Bekasi', '1958-12-22', '085710394994', 'Kp. Pulomurub RT/RW 02/03 Desa Sukawijaya Kec. Tambelang', 'Menikah', 'Pegawai Negri Sipil(PNS)', 'Ayah', 'anbsjdga', '0589854', '2018-12-22', 'P004'),
('RM0014', 'TEST', '3223344', 'Laki-laki', 'A', 'Islam', 'BEKASI', '1990-01-19', '09889888', 'BEKASI', 'Belum Nikah', 'Karyawan', 'Ayah', 'TEST', '09888877', '2019-01-19', 'P008'),
('RM0015', 'desi', '19823990909', 'Perempuan', 'B', 'Islam', 'kebumen', '1978-12-15', '668789890898', 'cikarang', 'Belum Nikah', 'Karyawan', 'Ayah', 'surya', '188878788998', '2019-02-17', 'P009');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE IF NOT EXISTS `pendaftaran` (
  `no_daftar` char(7) NOT NULL,
  `nomor_rm` char(6) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `tgl_janji` date NOT NULL,
  `jam_janji` time NOT NULL,
  `keluhan` varchar(100) NOT NULL,
  `kd_tindakan` char(4) NOT NULL,
  `nomor_antri` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_daftar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`no_daftar`, `nomor_rm`, `tgl_daftar`, `tgl_janji`, `jam_janji`, `keluhan`, `kd_tindakan`, `nomor_antri`, `kd_petugas`) VALUES
('0000015', 'RM0002', '2018-12-23', '2018-12-23', '12:00:00', 'ada lah', 'T001', 2, 'P001'),
('0000014', 'RM0013', '2018-12-23', '2018-12-23', '14:00:00', 'keppo', 'T001', 1, 'P004'),
('0000016', 'RM0014', '2019-01-19', '2019-01-19', '12:10:00', 'ADA', 'T001', 1, 'P008'),
('0000017', 'RM0013', '2019-01-19', '2019-01-19', '13:30:00', 'SAKIT', 'T002', 2, 'P001'),
('0000018', 'RM0014', '2019-01-19', '2019-01-19', '13:30:00', 'hjhjjjj', 'T002', 3, 'P001'),
('0000019', 'RM0015', '2019-02-17', '2019-02-17', '12:10:00', 'jhkhhjhjm,mlkjhhkh', 'T005', 1, 'P009');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `no_penjualan` char(7) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_penjualan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`no_penjualan`, `tgl_penjualan`, `pelanggan`, `keterangan`, `uang_bayar`, `kd_petugas`) VALUES
('JL00001', '2019-02-17', 'Pasien', '', 200000, 'P009'),
('JL00002', '2019-02-17', 'Pasien', '', 50000, 'P009');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_item`
--

CREATE TABLE IF NOT EXISTS `penjualan_item` (
  `no_penjualan` char(7) NOT NULL,
  `kd_obat` char(5) NOT NULL,
  `harga_modal` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  KEY `nomor_penjualan_tamu` (`no_penjualan`,`kd_obat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan_item`
--

INSERT INTO `penjualan_item` (`no_penjualan`, `kd_obat`, `harga_modal`, `harga_jual`, `jumlah`) VALUES
('JL00001', 'H0005', 10000, 15000, 1),
('JL00002', 'H0005', 10000, 15000, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir',
  PRIMARY KEY (`kd_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`kd_petugas`, `nm_petugas`, `no_telepon`, `username`, `password`, `level`) VALUES
('P001', 'Bunafit Nugroho', '081192345111', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('P003', 'Septi Suhesti', '081193342223', 'septi', 'd58d8a16aa666d48fbcc30bd3217fb17', 'Apotek'),
('P007', 'Dini', '08112236393', 'dini', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('P008', 'TEST', '09889888', 'USER123', '25d55ad283aa400af464c76d713c07ad', 'user'),
('P009', 'desi', '668789890898', 'user1010', '25d55ad283aa400af464c76d713c07ad', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rawat`
--

CREATE TABLE IF NOT EXISTS `rawat` (
  `no_rawat` char(7) NOT NULL,
  `tgl_rawat` date NOT NULL,
  `nomor_rm` char(6) NOT NULL,
  `hasil_diagnosa` varchar(100) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`no_rawat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rawat`
--

INSERT INTO `rawat` (`no_rawat`, `tgl_rawat`, `nomor_rm`, `hasil_diagnosa`, `uang_bayar`, `kd_petugas`) VALUES
('RP00001', '2019-01-19', 'RM0014', 'UHUHHUYH', 100000, 'P008'),
('RP00002', '2019-01-19', 'RM0013', 'GBKKKK', 200000, 'P001'),
('RP00003', '2019-01-19', 'RM0013', 'hgjhjh', 5000000, 'P001'),
('RP00004', '2019-02-17', 'RM0015', 'hgfffghvfhgvhtg', 400000, 'P009');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rawat_tindakan`
--

CREATE TABLE IF NOT EXISTS `rawat_tindakan` (
  `id_tindakan` int(7) NOT NULL AUTO_INCREMENT,
  `tgl_tindakan` date NOT NULL,
  `no_rawat` char(7) NOT NULL,
  `kd_tindakan` char(4) NOT NULL,
  `harga` int(10) NOT NULL,
  `kd_dokter` char(4) NOT NULL,
  `bagi_hasil_dokter` int(4) NOT NULL,
  PRIMARY KEY (`id_tindakan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data untuk tabel `rawat_tindakan`
--

INSERT INTO `rawat_tindakan` (`id_tindakan`, `tgl_tindakan`, `no_rawat`, `kd_tindakan`, `harga`, `kd_dokter`, `bagi_hasil_dokter`) VALUES
(24, '2019-01-19', 'RP00001', 'T001', 550000, 'D006', 10),
(25, '2019-01-19', 'RP00002', 'T001', 500000, 'D006', 10),
(26, '2019-01-19', 'RP00003', 'T002', 500000, 'D006', 10),
(27, '2019-01-19', 'RP00003', 'T005', 500000, 'D006', 10),
(28, '2019-02-17', 'RP00004', 'T005', 400000, 'D006', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan`
--

CREATE TABLE IF NOT EXISTS `tindakan` (
  `kd_tindakan` char(4) NOT NULL,
  `nm_tindakan` varchar(100) NOT NULL,
  `harga` int(10) NOT NULL,
  PRIMARY KEY (`kd_tindakan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tindakan`
--

INSERT INTO `tindakan` (`kd_tindakan`, `nm_tindakan`, `harga`) VALUES
('T001', 'Laser Flex - Rejuve - Jerawat - Menghilangkan Bulu - Tato', 500000),
('T002', 'Peeling Special', 250000),
('T003', 'Laser + Sulam Glowing (EPN)', 550000),
('T004', 'Stemp Cell/Bopeng', 550000),
('T005', 'Laser Kantung Mata (EPN)', 350000),
('T006', 'Suntik Jerawat / Keloid', 150000),
('T007', 'Laser Glowing+Kantung Mata', 800000),
('T008', 'Laser + Sulam Glowing + Kantung Mata + Rejuve Bibir', 900000),
('T009', 'Laser EPN Rambut Rontok', 400000),
('T010', 'Miss V Treatment Special', 500000),
('T011', 'Facial Spesial', 200000),
('T012', 'Facial Gold Special', 200000),
('T013', 'Facial Jerawat Special', 225000),
('T014', 'Facial Anak Special', 80000),
('T015', 'Totok Wajah Special', 60000),
('T016', 'Facial + Totok Wajah Special', 225000),
('T017', 'Facial + PDT Special', 225000),
('T018', 'Facial + Totok + PDT Special', 250000),
('T019', 'Pengencangan Wajah Special', 200000),
('T020', 'Facial + Pengencangan Wajah Special', 250000),
('T021', 'Facial + Detox + Pengencangan Wajah', 300000),
('T022', 'Make Up', 150000),
('T023', 'Keriting', 150),
('T024', 'Rebounding ', 300),
('T025', 'Potong Rambut', 50),
('T026', 'SPA Vagina', 60000),
('T027', 'Lulur', 130000),
('T028', 'Creambath', 100000),
('T029', 'Facial', 80000),
('T030', 'Facial Gold', 150000),
('T031', 'Facial Anak', 60000),
('T032', 'Totok Wajah', 60000),
('T033', 'Facial +Totok Wajah', 120000),
('T034', 'Facial + PDT', 130000),
('T035', 'Facial + Totok + PDT ', 180000),
('T036', 'Microdermabrasi', 150000),
('T037', 'Facial + Micro', 180000),
('T038', 'Pengencangan Wajah', 200000),
('T039', 'Facial + Pengencangan Wajah', 250000),
('T040', 'Aqua Peel', 200000),
('T041', 'Oxygen Facial', 200000),
('T042', 'Facial Treatment', 200000),
('T043', 'Hi Fu', 350000),
('T044', 'Spa / Message Badan', 150000),
('T045', 'Pengecilan Lengan', 300000),
('T046', 'Pengecilan Perut', 400000),
('T047', 'Pengecilan Paha', 400000),
('T048', 'Pengecilan Lengan & Perut', 600000),
('T049', 'Pengecilan Lengan & Perut & Paha', 1000000),
('T050', 'Peeling Tangan', 200000),
('T051', 'Peeling Kaki', 200000),
('T052', 'Peeling Badan', 400000),
('T053', 'Perawatan Kantung Mata', 100000),
('T054', 'Energetic Herbal Facial', 250000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_penjualan`
--

CREATE TABLE IF NOT EXISTS `tmp_penjualan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kd_obat` char(5) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_rawat`
--

CREATE TABLE IF NOT EXISTS `tmp_rawat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kd_tindakan` char(4) NOT NULL,
  `harga` int(12) NOT NULL,
  `kd_dokter` char(4) NOT NULL,
  `bagi_hasil_dokter` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
