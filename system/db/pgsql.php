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

namespace Vvveb\System\Db;

use Vvveb\System\Event;

class Pgsql extends DBDriver {
	private static $link = null;

	//public $error;

	private $stmt;

	private $last_res;

	public $affected_rows = 0;

	public $num_rows = 0;

	public $insert_id = null;

	private static $persistent = false;

	public $prefix = ''; //'vv_';

	public $quote  = '"';

	public static function version() {
		if (self :: $link) {
			return pg_version(self :: $link);
		}
	}

	public static function info() {
		if (self :: $link) {
			return pg_version(self :: $link);
		}
	}

	public function error() {
		if (self :: $link) {
			return pg_last_error(self :: $link) ?? '';
		}
		return 'No PostgreSQL connection available';
	}

	public function errorCode() {
		if (self :: $link) {
			// PostgreSQL doesn't have error codes like MySQL
			// Return 0 if connection exists, non-zero if error
			return pg_last_error(self :: $link) ? 1 : 0;
		}
		return 0;
	}

	public function get_result($stmt) {
		return $stmt;
	}

	public function __construct($host = DB_HOST, $dbname = DB_NAME, $user = DB_USER, $pass = DB_PASS, $port = DB_PORT, $prefix = DB_PREFIX) {
		//return $this->connect($host, $dbname, $user, $pass, $port,  $prefix);
	}

	public function connect($host = DB_HOST, $dbname = DB_NAME, $user = DB_USER, $pass = DB_PASS, $port = DB_PORT, $prefix = DB_PREFIX) {
		if (! self :: $link) {
			//port 5432 for direct pgsql connection 6432 for pgbouncer
			$port = $port ?: 5432;
			
			// Clean inputs - trim whitespace
			$host = trim((string)$host);
			$dbname = trim((string)$dbname);
			$user = trim((string)$user);
			$pass = trim((string)$pass);
			$port = (int)$port;
			
			// For Render.com PostgreSQL: if hostname doesn't contain a dot, try full domain
			// Render internal hostnames like "dpg-xxxxx-a" need full domain like "dpg-xxxxx-a.oregon-postgres.render.com"
			$hostnamesToTry = [$host];
			if (strpos($host, '.') === false && preg_match('/^dpg-[a-z0-9]+-[a-z]$/i', $host)) {
				// Try common Render PostgreSQL regions
				$regions = [
					'oregon-postgres.render.com',
					'frankfurt-postgres.render.com',
					'singapore-postgres.render.com',
					'ohio-postgres.render.com',
					'ireland-postgres.render.com',
				];
				foreach ($regions as $region) {
					$hostnamesToTry[] = "$host.$region";
				}
			}
			
			$lastError = null;
			$connectionAttempted = false;
			
			// Try each hostname until one works
			foreach ($hostnamesToTry as $tryHost) {
				// PostgreSQL connection string format:
				// "host=HOST port=PORT dbname=DBNAME user=USER password=PASS"
				$connect_string = "host=$tryHost port=$port dbname=$dbname user=$user password=$pass";

				// Clear any previous errors
				error_clear_last();
				
				// Attempt connection - use @ to suppress warnings, we'll handle errors ourselves
				if (self :: $persistent) {
					self :: $link = @pg_pconnect($connect_string);
				} else {
					self :: $link = @pg_connect($connect_string);
				}
				
				$connectionAttempted = true;

				// If connection succeeded, break out of loop
				if (self :: $link && self :: $link !== false) {
					// Update host to the working one for future reference
					$host = $tryHost;
					break;
				}
				
				// Save error for reporting
				$lastError = error_get_last();
			}

			// Check connection result
			if (! self :: $link || self :: $link === false) {
				// Connection failed - get detailed error information
				$errorMessages = [];
				$errorMessages[] = "PostgreSQL connection failed";
				
				// Get PHP error if available
				$lastError = error_get_last();
				if ($lastError) {
					$errorMessages[] = "PHP Error: " . $lastError['message'];
					$errorMsg = strtolower($lastError['message']);
					
					// Provide specific guidance based on error type
					if (strpos($errorMsg, 'could not connect') !== false || 
					    strpos($errorMsg, 'connection refused') !== false ||
					    strpos($errorMsg, 'no route to host') !== false) {
					$errorMessages[] = "\nTROUBLESHOOTING:";
					$errorMessages[] = "- DNS Resolution Failed: Hostname '$host' could not be resolved";
					$errorMessages[] = "- For Render PostgreSQL: Use full hostname like 'dpg-xxxxx-a.oregon-postgres.render.com'";
					$errorMessages[] = "- Check Render database dashboard for correct Internal Database URL";
					$errorMessages[] = "- Verify hostname is correct: $host";
					$errorMessages[] = "- Verify port is correct: $port";
					$errorMessages[] = "- Check if database server is running";
					$errorMessages[] = "- For Render: Ensure web service and database are in same region";
					$errorMessages[] = "- Check firewall/network settings";
					} elseif (strpos($errorMsg, 'authentication') !== false || 
					          strpos($errorMsg, 'password') !== false ||
					          strpos($errorMsg, 'ident') !== false) {
						$errorMessages[] = "\nTROUBLESHOOTING:";
						$errorMessages[] = "- Verify username is correct: $user";
						$errorMessages[] = "- Verify password is correct (check for typos)";
						$errorMessages[] = "- Check user permissions in PostgreSQL";
					} elseif (strpos($errorMsg, 'database') !== false && 
					          (strpos($errorMsg, 'does not exist') !== false || 
					           strpos($errorMsg, 'not found') !== false)) {
						$errorMessages[] = "\nTROUBLESHOOTING:";
						$errorMessages[] = "- Verify database name is correct: $dbname";
						$errorMessages[] = "- Database may not exist - create it first";
					}
				} else {
					$errorMessages[] = "No detailed error available - connection was refused";
					$errorMessages[] = "\nTROUBLESHOOTING:";
					$errorMessages[] = "- Check all connection parameters";
					$errorMessages[] = "- Verify database server is accessible";
					$errorMessages[] = "- Check network connectivity";
				}
				
				$errorMessages[] = "\nCONNECTION DETAILS:";
				$errorMessages[] = "Host: $host";
				$errorMessages[] = "Port: $port";
				$errorMessages[] = "Database: $dbname";
				$errorMessages[] = "User: $user";
				$errorMessages[] = "\nConnection string used: host=$host port=$port dbname=$dbname user=$user";
				
				throw new \Exception(implode("\n", $errorMessages));
			}

			// Connection successful - verify it works with a test query
			if (self :: $link) {
				// Test the connection
				$testResult = @pg_query(self :: $link, "SELECT version()");
				if (!$testResult) {
					// Connection exists but query failed
					$connError = pg_last_error(self :: $link);
					@pg_close(self :: $link);
					self :: $link = null;
					throw new \Exception(
						"Connection established but test query failed.\n" .
						"PostgreSQL Error: " . ($connError ?: 'Unknown error') . "\n" .
						"This may indicate database permission issues."
					);
				}
				@pg_free_result($testResult);
				
				// Set client encoding to UTF-8 for proper character handling
				@pg_set_client_encoding(self :: $link, 'UTF8');
			}
		}

		return self :: $link;
	}

	/*
	 * Get all columns for a table used for sanitizing input
	 */
	function getColumnsMeta($tableName, $comment = false) {
		$sql =
		"SELECT data_type as t, column_name as name, column_default as d, is_nullable as n, character_maximum_length as l FROM information_schema.columns WHERE table_name ='$tableName'";

		if ($result = $this->query($sql)) {
			//$columns = $result->fetch_all(MYSQLI_ASSOC);
			$columns = [];

			while ($row = pg_fetch_assoc($result)) {
				$columns[$row['name']] = $row;
			}

			/* free result set */
			return $columns;
		} else {
		}

		return false;
	}

	function getTableNames($db = DB_NAME) {
		$sql =
		"SELECT tablename as name FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema' ORDER BY name";

		if ($result = $this->query($sql)) {
			//$names = $result->fetch_all(MYSQLI_ASSOC);
			$names = [];

			while ($row = pg_fetch_assoc($result)) {
				//$columns[] = $row;
				$names[] = $row['name'];
			}

			/* free result set */
			return $names;
		} else {
		}

		return false;
	}

	public function escape($string) {
		if (is_string($string)) {
			return pg_escape_string(self :: $link, $string);
		}

		if (is_null($string)) {
			return 'null';
		}

		return $string;
	}

	public function escapeLiteral($string) {
		if (is_string($string)) {
			return pg_escape_literal(self :: $link, $string);
		}

		if (is_null($string)) {
			return 'null';
		}

		return $string;
	}

	public function sqlLimit($start, $limit) {
		return "LIMIT  $limit OFFSET $start";
	}

	public function fetchArray(&$result) {
		if (pg_num_rows($result)) {
			$values = pg_fetch_assoc($result);

			return $values;
		}

		return [];
	}

	public function fetchAll(&$result) {
		if (pg_num_rows($result)) {
			$values = pg_fetch_all($result);

			if ($result) {
				pg_free_result($result);
				$result = false;
			}

			return $values;
		}

		return [];
	}

	public function query($sql, $parameters = []) {
		if (! self :: $link) {
			$this->connect();
		}

		$result = false;
		$origSql = $sql; // Store original SQL for error messages

		try {
			if ($parameters) {
				if (LOG_SQL_QUERIES) {
					error_log($this->debugSql($sql, $parameters));
				}

				$this->last_res = $result = @pg_query_params(self :: $link, $sql, $parameters);
			} else {
				if (LOG_SQL_QUERIES) {
					error_log($sql);
				}

				$this->last_res = $result = @pg_query(self :: $link, $sql);
			}

			if ($this->last_res == false) {
				$errorMessage = pg_last_error(self :: $link);
				$message      = $errorMessage . "\n" . $this->debugSql($origSql, $parameters) . "\n - " . $origSql;

				throw new \Exception($message);
			}

			if ($result) {
				$this->affected_rows = @pg_affected_rows($this->last_res);
			}

			return $this->last_res;
		} catch (\Exception $e) {
			$message = $e->getMessage() . "\n - " . substr($origSql, 0, 500);

			throw new \Exception($message, $e->getCode());
		}

		return $result;
	}

	public function multi_query($sql) {
		// Ensure connection is established
		if (! self :: $link) {
			$this->connect();
		}
		
		// PostgreSQL can't execute multiple statements in one query
		// Split by semicolon and execute each statement separately
		// Remove single-line comments first (but preserve SQL in strings)
		$sql = preg_replace('/--.*$/m', '', $sql);
		
		// Split by semicolon followed by optional whitespace and newline/end
		// This handles both single-line and multi-line statements
		$statements = preg_split('/;\s*(?=\n|$)/m', $sql);
		
		foreach ($statements as $statement) {
			$statement = trim($statement);
			
			// Skip empty statements
			if (empty($statement)) {
				continue;
			}
			
			// Ensure statement ends with semicolon for pg_query
			if (substr($statement, -1) !== ';') {
				$statement .= ';';
			}
			
			// Execute each statement
			try {
				$result = $this->query($statement);
				
				if ($result === false) {
					$error = $this->error();
					throw new \Exception("SQL execution failed: " . $error . "\nStatement: " . substr($statement, 0, 200));
				}
			} catch (\Exception $e) {
				// Re-throw with context
				throw new \Exception($e->getMessage() . "\n\nFailed statement:\n" . substr($statement, 0, 500), $e->getCode());
			}
		}
		
		return true;
	}

	public function close() {
		if (self :: $link) {
			return pg_close(self :: $link);
		}
	}

	public function get_one($query, $parameters = null) {
		$res = $this->query($query, $parameters);

		if (pg_num_rows($res)) {
			return pg_fetch_result($res, 0, 0);
		} else {
			return false;
		}
	}

	function get_row($query, $parameters) {
		$res = $this->query($query . ' LIMIT 1', $parameters);

		if ($res === null) {
			$res = $this->last_res;
		}

		$values = pg_fetch_assoc($res);

		if ($res) {
			pg_free_result($res);
		}

		return $values;
	}

	public function get_all($query, $parameters = null) {
		$res = $this->query($query, $parameters);

		if (pg_num_rows($res)) {
			$values = pg_fetch_all($res);

			if ($res) {
				pg_free_result($res);
			}

			return $values;
		} else {
			return false;
		}
	}

	function fetch_row($res = null) {
		if ($res === null) {
			$res = $this->last_res;
		}

		$values = pg_fetch_assoc($res);

		if ($res) {
			pg_free_result($res);
		}

		return $values;
	}

	// Prepare
	public function execute($sql, $params = [], $paramTypes = []) {
		list($sql, $params) = Event::trigger(__CLASS__,__FUNCTION__, $sql, $params);
		//save orig sql for debugging info
		$origSql = $sql;

		if (! self :: $link) {
			$this->connect();
		}

		list($parameters, $types) = $this->paramsToQmark($sql, $params, $paramTypes, '$');

		if (LOG_SQL_QUERIES) {
			error_log($this->debugSql($origSql, $params, $paramTypes));
		}

		if ($parameters) {
			$this->last_res = pg_query_params(self :: $link, $sql, $parameters);
		} else {
			$this->last_res = pg_query(self :: $link, $sql);
			//pg_send_query(self :: $link, $sql);
			//$this->last_res = pg_get_result(self :: $link);
		}

		if ($this->last_res) {
			$this->affected_rows = @pg_affected_rows($this->last_res);
		}

		if ($this->last_res == false) {
			$errorMessage = pg_last_error(self :: $link);
			//error_log('pgsql error: ' . pg_last_error(self :: $link));
			$message = $errorMessage . "\n" . $this->debugSql($origSql, $params, $paramTypes) . "\n - " . $origSql . "\n - " . print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1), true);

			throw new \Exception($message);
		}

		return $this->last_res;
	}

	// Bind
	public function bind($param, $value, $type = null) {
		$this->stmt->bindValue($param, $value, $type);
	}
}
