<?php


class GenreModel extends Model
{

    public function getGenres()
    {
        $sql   = "SELECT * from genres";
        $query = $this->db->prepare( $sql );
        $query->execute();

        return $query->fetchAll();
    }

    public function getGenreById( $genreId )
    {
        $sql   = "SELECT * from genres where id=:genreId LIMIT 1";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':genreId' => $genreId
        ] );

        return $query->fetch();
    }

    public function saveGenre( $name )
    {
        $sql   = "INSERT INTO genres (name) values (:name)";
        $query = $this->db->prepare( $sql );
        $query->execute( [
            ':name' => $name
        ] );
    }

    public function deleteGenreById( $genreId )
    {
        $sql = "DELETE genres, book_to_genre
FROM genres
       INNER JOIN
     book_to_genre ON genres.id = book_to_genre.genre_id
WHERE genres.id = :genreId; ";

        $query = $this->db->prepare( $sql );

        return $query->execute( [
            ':genreId' => $genreId
        ] );
    }

    public function updateGenreById( $genreId, $name )
    {
        $sql   = "UPDATE genres SET
		name = :name
		WHERE id = :id";
        $query = $this->db->prepare( $sql );

        $query->execute( [
            ':name' => $name,
            ':id'   => $genreId
        ] );
    }

}