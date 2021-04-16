-- // add orders to customers relationship
-- Migration SQL that makes the change goes here.
ALTER TABLE orders
ADD CONSTRAINT PK_customers FOREIGN KEY (customerId) REFERENCES customers(id);
-- @UNDO
-- SQL to undo the change goes here.
ALTER TABLE orders
DROP FOREIGN KEY PK_customers;
