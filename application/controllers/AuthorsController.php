<?php


class AuthorsController extends Controller
{
    public function index(){


        if(!isset($_GET['author_id']))
        {
            header('Location: '.URL);

        }

        $authorId = trim($_GET['author_id']);
        $authorId = strip_tags($authorId);

        $authorModel = new AuthorModel();
        $authors = $authorModel->getAuthors();


        $currentAuthor = $authorModel->getAuthorById($authorId);

        $bookModel = new BookModel();
        $books = $bookModel->getBooksByAuthor($authorId);


        $genreModel = new GenreModel();
        $genres = $genreModel->getGenres();


        $data = [
            'title' => $currentAuthor->name.' books',
            'authors' => $authors,
            'current_author'=>$currentAuthor,
            'books' => $books,
            'genres'=>$genres
        ];

        $this->loadView( 'author_books', $data );
    }
}