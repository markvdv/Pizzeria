<?php
namespace Pizzeria\Data;
class DAO {
protected static $db;
protected static $stmt;
protected static $lastInsertId;
    /** execPreppedStmt
     * 
     * @param string $sql: sql string 
     * @param array $args: array met parameters van functie om te binden
     * @return PDOstatement $stmt: PDO statement met de resultaten
     */
    protected static function execPreppedStmt($sql, $args = null) {
        self::$db = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        self::$stmt = self::$db->prepare($sql);
        if ($args != null) {
            self::$stmt->execute($args);
        } else {
            self::$stmt->execute();
        }
        self::$lastInsertId = self::$db->lastInsertId();
        self::$db = null;
    }

    public static function getLastInsertId() {
        return self::$lastInsertId;
    }

}

