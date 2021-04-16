-- // add orders to order-items relationship
-- Migration SQL that makes the change goes here.
ALTER TABLE order_items
ADD CONSTRAINT PK_orders FOREIGN KEY (orderId) REFERENCES orders(id);
-- @UNDO
-- SQL to undo the change goes here.
ALTER TABLE order_items
DROP FOREIGN KEY PK_orders;
