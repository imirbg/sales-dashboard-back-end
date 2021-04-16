-- // add purchaseDate index on orders table
-- Migration SQL that makes the change goes here.
CREATE INDEX index_purchaseDate
ON orders (purchaseDate);
-- @UNDO
-- SQL to undo the change goes here.
DROP INDEX index_purchaseDate ON orders;
