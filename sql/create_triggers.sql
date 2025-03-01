DELIMITER $$

CREATE TRIGGER books_update_timestamp BEFORE
UPDATE ON Books FOR EACH ROW
SET
  NEW.updated_at = CURRENT_TIMESTAMP;

END $$

CREATE TRIGGER users_update_timestamp BEFORE
UPDATE ON Users FOR EACH ROW
SET
  NEW.updated_at = CURRENT_TIMESTAMP;

END $$

CREATE TRIGGER loans_update_timestamp BEFORE
UPDATE ON Loans FOR EACH ROW
SET
  NEW.modified_at = CURRENT_TIMESTAMP;

END $$

CREATE TRIGGER make_book_unavailable BEFORE INSERT ON Loans FOR EACH ROW BEGIN
UPDATE Books
SET
  available = FALSE
WHERE
  isbn = NEW.book_isbn;

END $$

CREATE TRIGGER make_book_available BEFORE
UPDATE ON Loans FOR EACH ROW BEGIN IF NEW.returned_date IS NOT NULL THEN
UPDATE Books
SET
  available = TRUE
WHERE
  isbn = OLD.book_isbn;

END IF;

END $$

DELIMITER ;
