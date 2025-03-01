CREATE VIEW AvailableBooks AS
SELECT
  isbn,
  title,
  author,
  publication_date,
  available,
  created_at,
  updated_at
FROM
  Books
WHERE
  available = TRUE;
