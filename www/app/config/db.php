<?php
class Database
{
	private static $db;

	public static function open()
	{
		self::$db = new mysqli('mysql-server', 'root', 'root', 'final');
		return self::$db;
	}
}
