<?php


class GenresController extends Controller
{
    public function index()
    {
        if ( isset( $_GET['genre_id'] ) ) {
            header( 'Location: ' . URL );
        }

        $authorsModel = new AuthorModel();
        $authors      = $authorsModel->getAuthors();

        $genreId = trim( $_GET['genre_id'] );
        $genreId = strip_tags( $genreId );

        $booksModel = new BookModel();
        $books      = $booksModel->getBooksByGenre( $genreId );

        $genreModel   = new GenreModel();
        $genres       = $genreModel->blockGenres();
        $currentGenre = $genreModel->getGenreById( $genreId );

        $data = [
            'title'         => $currentGenre->name,
            'genres'        => $genres,
            'authors'       => $authors,
            'books'         => $books,
            'current_genre' => $currentGenre
        ];

        $this->loadView( 'genre_books', $data );

    }
}