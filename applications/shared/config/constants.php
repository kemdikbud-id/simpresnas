<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Model name
define('MODEL_FILE_PROPOSAL', 'File_proposal_model');
define('MODEL_FILE_EXPO', 'File_expo_model');
define('MODEL_KEGIATAN', 'Kegiatan_model');
define('MODEL_LEMBAGA_PENGUSUL', 'LembagaPengusul_model');
define('MODEL_PERGURUAN_TINGGI', 'PerguruanTinggi_model');
define('MODEL_PROGRAM', 'Program_model');
define('MODEL_SYARAT', 'Syarat_model');
define('MODEL_PROPOSAL', 'Proposal_model');
define('MODEL_ANGGOTA_PROPOSAL', 'Anggota_proposal_model');
define('MODEL_REQUEST_USER', 'RequestUser_model');
define('MODEL_USER', 'User_model');
define('MODEL_REJECT_MESSAGE', 'RejectMessage_model');
define('MODEL_REVIEWER', 'Reviewer_model');
define('MODEL_PLOT_REVIEWER', 'PlotReviewer_model');
define('MODEL_TAHAPAN', 'Tahapan_model');
define('MODEL_TAHAPAN_PROPOSAL', 'TahapanProposal_model');
define('MODEL_KATEGORI', 'Kategori_model');
define('MODEL_UNIT_KEWIRAUSAHAAN', 'Unit_kewirausahaan_model');
define('MODEL_PROFIL_KELOMPOK', 'Profil_kelompok_model');

// Jenis Program
defined('PROGRAM_PBBT')	or define('PROGRAM_PBBT', 1);
defined('PROGRAM_KBMI')	or define('PROGRAM_KBMI', 2);
defined('PROGRAM_EXPO')	or define('PROGRAM_EXPO', 3);
defined('PROGRAM_WORKSHOP')	or define('PROGRAM_WORKSHOP', 4);

// Jenis User
defined('TIPE_USER_NORMAL')			or define('TIPE_USER_NORMAL', 1);
defined('TIPE_USER_REVIEWER')		or define('TIPE_USER_REVIEWER', 2);
defined('TIPE_USER_VERIFIKATOR')	or define('TIPE_USER_VERIFIKATOR', 3);
defined('TIPE_USER_ADMIN')			or define('TIPE_USER_ADMIN', 99);

// Tahapan Proposal
defined('TAHAPAN_EVALUASI')			or define('TAHAPAN_EVALUASI', 1);
defined('TAHAPAN_MONEV')			or define('TAHAPAN_MONEV', 2);
defined('TAHAPAN_SELEKSI_EXPO')		or define('TAHAPAN_SELEKSI_EXPO', 3);
defined('TAHAPAN_KMI_AWARD')		or define('TAHAPAN_KMI_AWARD', 4);
defined('TAHAPAN_STAND_EXPO')		or define('TAHAPAN_STAND_EXPO', 5);