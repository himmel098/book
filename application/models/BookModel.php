<?php


class BookModel extends Model
{
    public function getBooks()
    {
        $sql   = "SELECT * from books";
        $query = $this->db->prepare( $sql );
        $query->execute();

        return $query->fetchAll();

    }

    public function getBooksByAuthor( $authorId )
    {
        $sql   = "select b.id, b.name, b.price, b.image
			from books b, authors a,
			book_to_author ba
			where
			ba.book_id = b.id
			and a.id = ba.author_id
			and a.id = :authorId";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':authorId' => $authorId
        ] );

        return $query->fetchAll();
    }

    public function getBookById( $booksId )
    {
        $sql   = "select b.id, b.name, b.description, b.price, b.year, b.image,
						GROUP_CONCAT(DISTINCT g.name) as genre,
						GROUP_CONCAT(DISTINCT a.name) as author
			from books b, genres g, authors a,
			book_to_genre bg, book_to_author ba
			where
			bg.book_id = b.id
			and ba.book_id = b.id
			and g.id = bg.genre_id
			and a.id = ba.author_id
			and b.id = :bookId
			GROUP BY b.name";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':bookId' => $booksId
        ] );

        return $query->fetch();
    }

    public function deleteBookById( $bookId )
    {
        $sql = "DELETE books,book_to_author, book_to_genre
FROM books
       INNER JOIN
     book_to_author ON books.id = book_to_author.book_id
       inner JOIN book_to_genre ON books.id = book_to_genre.book_id
WHERE books.id = :book_id; ";

        $query = $this->db->prepare( $sql );

        return $query->execute( [
            ':book_id' => $bookId
        ] );
    }

    public function updateBookById( $bookId, $variables )
    {

        $sql   = "UPDATE books SET
		name = :name,
		description = :description,
		price = :price,
		year = :year,
		image = :image
		WHERE id = :id";
        $query = $this->db->prepare( $sql );

        $query->execute( [
            ':name'        => $variables['name'],
            ':description' => $variables['description'],
            ':price'       => $variables['price'],
            ':year'        => $variables['year'],
            ':image'       => $variables['image'],
            ':id'          => $bookId
        ] );

        $sql = "DELETE FROM book_to_genre where book_id=:bookId";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':bookId'          => $bookId
        ] );

        $sql = "DELETE FROM book_to_author where book_id=:bookId";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':bookId'          => $bookId
        ] );

        foreach ($variables['authors'] as $authorId){
            $sql = "INSERT INTO book_to_author (book_id, author_id) values (:bookId, :authorId)";
            $query = $this->db->prepare( $sql );
            $query->execute( [
                ':bookId'          => $bookId,
                ':authorId'          => $authorId
            ] );
        }

        foreach ($variables['genres'] as $genreId){
            $sql = "INSERT INTO book_to_genre (book_id, genre_id) values (:bookId, :genreId)";
            $query = $this->db->prepare( $sql );
            $query->execute( [
                ':bookId'          => $bookId,
                ':genreId'          => $genreId
            ] );
        }
    }

    public function saveBook( $variables )
    {
        $sql = "INSERT INTO books (name, description, image, price, year) values (:name, :description, :image, :price, :year)";
        $query = $this->db->prepare( $sql );

        $query->execute( [
            ':name'        => $variables['name'],
            ':description' => $variables['description'],
            ':price'       => $variables['price'],
            ':year'        => $variables['year'],
            ':image'       => $variables['image'],
        ] );

        $bookId = $this->db->lastInsertId();

        foreach ($variables['authors'] as $authorId){
            $sql = "INSERT INTO book_to_author (book_id, author_id) values (:bookId, :authorId)";
            $query = $this->db->prepare( $sql );
            $query->execute( [
                ':bookId'          => $bookId,
                ':authorId'          => $authorId
            ] );
        }

        foreach ($variables['genres'] as $genreId){
            $sql = "INSERT INTO book_to_genre (book_id, genre_id) values (:bookId, :genreId)";
            $query = $this->db->prepare( $sql );
            $query->execute( [
                ':bookId'          => $bookId,
                ':genreId'          => $genreId
            ] );
        }
    }

}