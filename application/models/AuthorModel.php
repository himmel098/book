<?php


class AuthorModel extends Model
{
    public function getAuthors()
    {
        $sql   = "SELECT * from authors";
        $query = $this->db->prepare( $sql );
        $query->execute();

        return $query->fetchAll();

    }

    public function getAuthorById( $authorId )
    {
        $sql   = "SELECT * from authors where id=:authorId LIMIT 1";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':authorId' => $authorId
        ] );

        return $query->fetch();
    }

    public function updateAuthorById( $authorId, $name )
    {
        $sql   = "UPDATE authors SET
		name = :name
		WHERE id = :id";
        $query = $this->db->prepare( $sql );

        $query->execute( [
            ':name' => $name,
            ':id'   => $authorId
        ] );
    }

    public function deleteAuthorById( $authorId )
    {
        $sql = "DELETE authors, book_to_author
FROM authors
       INNER JOIN
     book_to_author ON authors.id = book_to_author.author_id
WHERE authors.id = :authorId; ";

        $query = $this->db->prepare( $sql );

        return $query->execute( [
            ':authorId' => $authorId
        ] );
    }

    public function saveAuthor( $name )
    {
        $sql   = "INSERT INTO authors (name) values (:name)";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':name' => $name
        ] );
    }

}