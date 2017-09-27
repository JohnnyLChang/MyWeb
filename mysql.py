# -*- coding: utf8 -*-
#!/usr/bin/python

# 引入 MySQL 模組
import MySQLdb
import uniout
import sys

print sys.getdefaultencoding()

# 連接到 MySQL
db = MySQLdb.connect(charset='utf8',
                     init_command='SET NAMES UTF8',
                     host="127.0.0.1",
                     user="root",
                     passwd="Crypto!@3",
                     db="mycourse_20170526",
                     ssl={'ca': '/etc/mysql/ssl/mysql-ca.crt',
                          'key': '/etc/mysql/ssl/client-key.pem',
                          'cert': '/etc/mysql/ssl/client-cert.pem'
                          }
                     )
cursor = db.cursor()

# 執行 SQL 語句
cursor.execute("SELECT * FROM course")
result = cursor.fetchall()

# 輸出結果
for record in result:
    print record
