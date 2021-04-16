-- // add orders table
-- Migration SQL that makes the change goes here.
CREATE TABLE orders
(
    id           INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    purchaseDate DATE,
    country      VARCHAR(100),
    device       VARCHAR(50),
    customerId   INTEGER
)

-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE orders;
