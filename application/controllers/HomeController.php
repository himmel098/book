<?php

class HomeController extends Controller
{

    public function index()
    {
        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthors();


        $bookModel = new BookModel();
        $books     = $bookModel->getBooks();

        $genreModel = new GenreModel();
        $genres     = $genreModel->getGenres();

        $data = [
            'title'   => 'Home page',
            'authors' => $authors,
            'books'   => $books,
            'genres'  => $genres
        ];


        $this->loadView( 'index', $data );
    }
}
