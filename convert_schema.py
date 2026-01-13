#!/usr/bin/env python3
import re

def convert_mysql_to_postgresql(mysql_sql):
    pg_sql = mysql_sql
    
    pg_sql = re.sub(r'/\*!.*?\*/', '', pg_sql)
    pg_sql = re.sub(r'SET SQL_MODE.*?;', '', pg_sql)
    pg_sql = re.sub(r'SET time_zone.*?;', '', pg_sql)
    pg_sql = re.sub(r'SET NAMES.*?;', '', pg_sql)
    
    pg_sql = re.sub(r'`', '"', pg_sql)
    
    pg_sql = re.sub(r'\)\s*ENGINE\s*=\s*\w+[^;]*;', ');', pg_sql)
    
    pg_sql = re.sub(r'tinyint\(\d+\)', 'SMALLINT', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'bigint\(\d+\)', 'BIGINT', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'int\(\d+\)', 'INTEGER', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\bdouble\b', 'DOUBLE PRECISION', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\bfloat\b', 'REAL', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\blongtext\b', 'TEXT', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\bmediumtext\b', 'TEXT', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\bdatetime\b', 'TIMESTAMP', pg_sql, flags=re.IGNORECASE)
    
    def enum_to_varchar(match):
        return "VARCHAR(50)"
    pg_sql = re.sub(r"enum\s*\([^)]+\)", enum_to_varchar, pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r'\s+CHARACTER SET\s+\w+', '', pg_sql, flags=re.IGNORECASE)
    pg_sql = re.sub(r'\s+COLLATE\s+\w+', '', pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r"\s+COMMENT\s+'[^']*'", '', pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r"DEFAULT '0000-00-00 00:00:00'", "DEFAULT NULL", pg_sql)
    pg_sql = re.sub(r"'0000-00-00 00:00:00'", "NULL", pg_sql)
    pg_sql = re.sub(r"'0000-00-00'", "NULL", pg_sql)
    
    pg_sql = re.sub(r'\bAUTO_INCREMENT\b', '', pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r'ROW_FORMAT\s*=\s*\w+', '', pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r'ALTER TABLE.*?MODIFY.*?AUTO_INCREMENT.*?;', '', pg_sql, flags=re.DOTALL)
    
    pg_sql = re.sub(r'^\s*ADD KEY.*?$', '', pg_sql, flags=re.MULTILINE)
    
    pg_sql = re.sub(r',\s*\n\s*\)', '\n)', pg_sql)
    
    pg_sql = re.sub(r'\s+DEFAULT\s+NULL\s+NOT\s+NULL', ' NOT NULL', pg_sql, flags=re.IGNORECASE)
    
    pg_sql = re.sub(r'\n{3,}', '\n\n', pg_sql)
    
    return pg_sql

with open('Database.sql', 'r', encoding='utf-8', errors='ignore') as f:
    mysql_content = f.read()

pg_content = convert_mysql_to_postgresql(mysql_content)

with open('database_pg.sql', 'w', encoding='utf-8') as f:
    f.write(pg_content)

print("Conversion complete! Check database_pg.sql")
