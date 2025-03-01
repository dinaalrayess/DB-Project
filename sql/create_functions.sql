DELIMITER $$

CREATE FUNCTION GetBookTitleByISBN(p_isbn VARCHAR(20))
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    DECLARE book_title VARCHAR(255);
    
    SELECT title INTO book_title
    FROM Books
    WHERE isbn = p_isbn;

    RETURN book_title;
END $$

CREATE FUNCTION IsBookAvailable(p_isbn VARCHAR(20))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE available BOOLEAN;

    SELECT available INTO available
    FROM Books
    WHERE isbn = p_isbn;

    RETURN available;
END $$

CREATE FUNCTION CountActiveLoansForUser(p_user_id INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE loan_count INT;

    SELECT COUNT(*) INTO loan_count
    FROM Loans
    WHERE user_id = p_user_id AND returned_date IS NULL;

    RETURN loan_count;
END $$

CREATE FUNCTION GetFullName(p_user_id INT)
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    DECLARE full_name VARCHAR(255);

    SELECT CONCAT(first_name, ' ', last_name) INTO full_name
    FROM Users
    WHERE id = p_user_id;

    RETURN full_name;
END $$

DELIMITER ;

