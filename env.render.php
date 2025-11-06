<?php

/**
 * Vvveb
 *
 * Copyright (C) 2022  Ziadin Givan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

//Render.com production settings
//Copy this to env.php after deployment or merge settings

define('SQL_CHECK', false);
define('PAGE_CACHE', true);
defined('DEBUG') || define('DEBUG', false);
defined('VTPL_DEBUG') || define('VTPL_DEBUG', false);
defined('DISABLE_PLUGIN_ON_ERORR') || define('DISABLE_PLUGIN_ON_ERORR', true);
defined('V_SUBDIR_INSTALL') || define('V_SUBDIR_INSTALL', false);
defined('V_SHARED_SESSION') || define('V_SHARED_SESSION', false);
defined('LOG_SQL_QUERIES') || define('LOG_SQL_QUERIES', false);
defined('REST') || define('REST', false);
defined('GRAPHQL') || define('GRAPHQL', false);
defined('GRAPHQL_CAMELCASE') || define('GRAPHQL_CAMELCASE', true);
defined('STRIP_EXIF') || define('STRIP_EXIF', true);

if (DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	error_reporting(0);
	ini_set('display_errors', 0);
}

