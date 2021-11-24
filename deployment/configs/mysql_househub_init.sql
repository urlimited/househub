CREATE DATABASE IF NOT EXISTS househub;
CREATE DATABASE IF NOT EXISTS househub_testing;
CREATE USER 'mysql_househub_testing'@'%' IDENTIFIED BY 'pp8UxXePLsVpMjEc';
CREATE USER 'mysql_househub'@'%' IDENTIFIED BY '4MqMQ7MpgC976rKP';
GRANT ALL PRIVILEGES ON househub_testing.* TO 'mysql_househub_testing'@'%';
GRANT ALL PRIVILEGES ON househub.* TO 'mysql_househub'@'%';
