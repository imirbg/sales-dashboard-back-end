-- // add order_items table
-- Migration SQL that makes the change goes here.
CREATE TABLE order_items
(
    id       INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    orderId  INTEGER,
    ean      CHAR(13),
    quantity SMALLINT,
    price    DECIMAL(8, 2)
);
-- @UNDO
-- SQL to undo the change goes here.
DROP TABLE order_items;
