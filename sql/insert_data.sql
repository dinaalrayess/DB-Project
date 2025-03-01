INSERT INTO
  Books (isbn, title, author, publication_date, available)
VALUES
  (
    '978-3-16-148410-0',
    'The Great Gatsby',
    'F. Scott Fitzgerald',
    '1925-04-10',
    TRUE
  ),
  (
    '978-0-7432-7356-5',
    'To Kill a Mockingbird',
    'Harper Lee',
    '1960-07-11',
    TRUE
  ),
  (
    '978-0-452-28423-4',
    '1984',
    'George Orwell',
    '1949-06-08',
    FALSE
  ),
  (
    '978-0-06-112008-4',
    'The Catcher in the Rye',
    'J.D. Salinger',
    '1951-07-16',
    TRUE
  ),
  (
    '978-0-7432-7357-2',
    'The Da Vinci Code',
    'Dan Brown',
    '2003-03-18',
    TRUE
  );

INSERT INTO
  Users (first_name, last_name, email, password, role)
VALUES
  (
    'John',
    'Doe',
    'john.doe@example.com',
    'password123',
    'user'
  ),
  (
    'Jane',
    'Smith',
    'jane.smith@example.com',
    'securepassword',
    'admin'
  ),
  (
    'Alice',
    'Johnson',
    'alice.johnson@example.com',
    'mypassword',
    'user'
  ),
  (
    'Bob',
    'Brown',
    'bob.brown@example.com',
    'anotherpassword',
    'user'
  );

INSERT INTO
  Loans (user_id, book_isbn, checkout_date, due_date)
VALUES
  (
    1,
    '978-3-16-148410-0',
    '2023-10-01',
    '2023-10-15'
  ),
  (
    2,
    '978-0-7432-7356-5',
    '2023-10-02',
    '2023-10-16'
  ),
  (
    1,
    '978-0-452-28423-4',
    '2023-10-03',
    '2023-10-17'
  ),
  (
    3,
    '978-0-06-112008-4',
    '2023-10-04',
    '2023-10-18'
  );
