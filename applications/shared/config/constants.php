<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Model name
define('MODEL_FILE_PROPOSAL', 'FileProposal_model');
define('MODEL_KEGIATAN', 'Kegiatan_model');
define('MODEL_LEMBAGA_PENGUSUL', 'LembagaPengusul_model');
define('MODEL_PERGURUAN_TINGGI', 'PerguruanTinggi_model');
define('MODEL_PROGRAM', 'Program_model');
define('MODEL_PROPOSAL', 'Proposal_model');
define('MODEL_REQUEST_USER', 'RequestUser_model');
define('MODEL_USER', 'User_model');
define('MODEL_REJECT_MESSAGE', 'RejectMessage_model');
define('MODEL_REVIEWER', 'Reviewer_model');
define('MODEL_TAHAPAN', 'Tahapan_model');

// Jenis Program
defined('PROGRAM_PBBT')	or define('PROGRAM_PBBT', 1);
defined('PROGRAM_KBMI')	or define('PROGRAM_KBMI', 2);

// Jenis User
defined('TIPE_USER_NORMAL')			or define('TIPE_USER_NORMAL', 1);
defined('TIPE_USER_REVIEWER')		or define('TIPE_USER_REVIEWER', 2);
defined('TIPE_USER_VERIFIKATOR')	or define('TIPE_USER_VERIFIKATOR', 3);
defined('TIPE_USER_ADMIN')			or define('TIPE_USER_ADMIN', 99);