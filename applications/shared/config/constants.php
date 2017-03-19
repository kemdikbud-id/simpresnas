<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Jenis Program
defined('PROGRAM_PBBT')	or define('PROGRAM_PBBT', 1);
defined('PROGRAM_KBMI')	or define('PROGRAM_KBMI', 2);

// Jenis User
defined('TIPE_USER_NORMAL')			or define('TIPE_USER_NORMAL', 1);
defined('TIPE_USER_REVIEWER')		or define('TIPE_USER_REVIEWER', 2);
defined('TIPE_USER_VERIFIKATOR')	or define('TIPE_USER_VERIFIKATOR', 3);
defined('TIPE_USER_ADMIN')			or define('TIPE_USER_ADMIN', 99);