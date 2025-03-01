DELIMITER $$

CREATE PROCEDURE InsertBook(
    IN p_isbn VARCHAR(20),
    IN p_title VARCHAR(255),
    IN p_author VARCHAR(255),
    IN p_publication_date DATE,
    IN p_available BOOLEAN
)
BEGIN
    INSERT INTO Books (isbn, title, author, publication_date, available)
    VALUES (p_isbn, p_title, p_author, p_publication_date, p_available);
END $$

CREATE PROCEDURE DeleteBook(
    IN p_isbn VARCHAR(20)
)
BEGIN
    DELETE FROM Books WHERE isbn = p_isbn;
END $$

CREATE PROCEDURE InsertUser(
    IN p_first_name VARCHAR(100),
    IN p_last_name VARCHAR(100),
    IN p_email VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_role ENUM('student', 'faculty', 'staff'),
    IN p_active BOOLEAN
)
BEGIN
    INSERT INTO Users (first_name, last_name, email, phone, role, active)
    VALUES (p_first_name, p_last_name, p_email, p_phone, p_role, p_active);
END $$

CREATE PROCEDURE DeleteUser(
    IN p_id INT
)
BEGIN
    DELETE FROM Users WHERE id = p_id;
END $$

CREATE PROCEDURE InsertLoan(
    IN p_user_id INT,
    IN p_book_isbn VARCHAR(20),
    IN p_checkout_date DATE,
    IN p_due_date DATE
)
BEGIN
    INSERT INTO Loans (user_id, book_isbn, checkout_date, due_date)
    VALUES (p_user_id, p_book_isbn, p_checkout_date, p_due_date);
END $$

CREATE PROCEDURE DeleteLoan(
    IN p_id INT
)
BEGIN
    DELETE FROM Loans WHERE id = p_id;
END $$

DELIMITER ;
