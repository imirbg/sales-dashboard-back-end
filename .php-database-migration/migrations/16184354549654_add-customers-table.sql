-- // add customers table
-- Migration SQL that makes the change goes here.
CREATE TABLE customers
(
    id        INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50),
    lastName  VARCHAR(50),
    email     VARCHAR(50)
);
-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE customers;
