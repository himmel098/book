<?php

class BooksController extends Controller
{
    public function index()
    {
        $bookModel = new BookModel();
        $books     = $bookModel->getBooks();

        $data = [
            'title' => 'Manage books',
            'books' => $books
        ];

        $this->loadView( 'admin/books', $data );
    }

    public function add()
    {

        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthors();
        $genreModel  = new GenreModel();
        $genres      = $genreModel->getGenres();

        $data = [
            'title'   => 'Add book',
            'authors' => $authors,
            'genres'  => $genres
        ];

        $this->loadView( 'admin/add_book', $data );
    }

    public function save()
    {
        if ( ! isset( $_POST['submit'] ) ) {
            header( 'Location: ' . URL . 'admin/books/add' );
        }
        $result = $this->validate();

        if ( ! empty( $result['errors'] ) ) {
            $data        = [
                'errors' => $result['errors']
            ];
            $authorModel = new AuthorModel();
            $authors     = $authorModel->getAuthors();
            $genreModel  = new GenreModel();
            $genres      = $genreModel->getGenres();

            $data = array_merge( [
                'title'   => 'Add book',
                'authors' => $authors,
                'genres'  => $genres,


            ], $data );

            $this->loadView( 'admin/add_book', $data );
        } else {
            $result['variables']['image'] = $this->saveImage();

            $bookModel = new BookModel();
            $bookModel->saveBook( $result['variables'] );
            header( 'Location: ' . URL . 'admin/books' );
        }
    }

    public function edit()
    {
        if ( ! isset( $_GET['book_id'] ) ) {
            header( 'Location:' . URL . '/admin/books' );
        }

        $bookId = trim( $_GET['book_id'] );
        $bookId = strip_tags( $bookId );

        $bookModel = new BookModel();
        $book      = $bookModel->getBookById( $bookId );

        $book->genres  = explode( ',', $book->genre );
        $book->authors = explode( ',', $book->author );

        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthors();
        $genreModel  = new GenreModel();
        $genres      = $genreModel->getGenres();

        $data = [
            'title'   => 'Edit book',
            'book'    => $book,
            'authors' => $authors,
            'genres'  => $genres
        ];

        $this->loadView( 'admin/edit_book', $data );
    }

    public function update()
    {
        if ( ! isset( $_POST['book_id'] ) ) {
            header( 'Location:' . URL . '/admin/books' );
        }

        $bookId = $_POST['book_id'];

        $result = $this->validate();

        $bookModel = new BookModel();
        $book      = $bookModel->getBookById( $bookId );

        if ( ! empty( $result['errors'] ) ) {
            $data = [
                'errors' => $result['errors']
            ];

        } else {
            $result['variables']['image'] = empty( $_FILES['image'] ) ? $book->image : $this->saveImage();

            $bookModel = new BookModel();
            $bookModel->updateBookById( $bookId, $result['variables'] );
        }

        $book = $bookModel->getBookById( $bookId );

        $book->genres  = explode( ',', $book->genre );
        $book->authors = explode( ',', $book->author );

        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthors();
        $genreModel  = new GenreModel();
        $genres      = $genreModel->getGenres();

        $data = array_merge( [
            'title'           => 'Edit book',
            'book'            => $book,
            'authors'         => $authors,
            'genres'          => $genres,
            'success_message' => 'Book updated'
        ], $data );

        $this->loadView( 'admin/edit_book', $data );

    }

    public function delete()
    {
        $bookId = trim( $_GET['book_id'] );
        $bookId = strip_tags( $bookId );

        if ( empty( $bookId ) || ! is_numeric( $bookId ) ) {
            $data = [
                'errors' => 'not valid id'
            ];
        } else {
            $bookModel = new BookModel();
            $result    = $bookModel->deleteBookById( $bookId );

            if ( $result ) {
                $data = [
                    'message' => 'book deleted',
                ];
            } else {
                $data = [
                    'errors' => "book wasn't deleted",
                ];
            }
        }


        $bookModel = new BookModel();
        $books     = $bookModel->getBooks();

        $data = array_merge( [
            'title' => 'Manage books',
            'books' => $books
        ], $data );

        $this->loadView( 'admin/books', $data );
    }

    private function validate()
    {
        $errors = [];

        if ( isset( $_POST['id'] ) ) {
            $variables['id'] = $_POST['id'];
            if ( ! is_numeric( $variables['id'] ) ) {
                $errors ['id'] = 'you are a bad hacker!';
            }
        }
        $variables['name'] = trim( $_POST['name'] );
        $variables['name'] = strip_tags( $variables['name'] );
        if ( strlen( $variables['name'] ) < 2 || strlen( $variables['name'] ) > 60 ) {
            $errors['name'] = 'name length must be more 2 and less then 60';
        }

        $variables['description'] = trim( $_POST['description'] );
        $variables['description'] = strip_tags( $variables['description'] );
        if ( strlen( $variables['description'] ) < 12 || strlen( $variables['description'] ) > 2000 ) {
            $errors['description'] = 'description length must be more 12 and less then 2000';
        } else {
            $variables['description'] = htmlspecialchars( $variables['description'], ENT_QUOTES );
        }

        $variables['price'] = trim( $_POST['price'] );
        $variables['price'] = strip_tags( $variables['price'] );
        if ( ! is_numeric( $variables['price'] ) ) {
            $errors['price'] = 'price must be numeric more then 0 and less then 10 000';
        }

        $variables['year'] = trim( $_POST['year'] );
        $variables['year'] = strip_tags( $variables['year'] );
        if ( ! is_numeric( $variables['year'] ) ) {
            $errors['year'] = 'year must be year';
        }

        if ( ! isset( $_POST['authors'] ) || ! isset( $_POST['genres'] ) ) {
            $errors[''] = 'select at list one author and one genre from the list';
        }

        foreach ( $_POST['authors'] as $author ) {
            $author = strip_tags( $author );
            if ( ! is_numeric( $author ) ) {
                $errors['authors'] = 'select author from the list';
            } else {
                $variables['authors'][] = $author;
            }
        }

        foreach ( $_POST['genres'] as $genre ) {
            $genre = strip_tags( $genre );
            if ( ! is_numeric( $genre ) ) {
                $errors['genres'] = 'select genre from the list';
            } else {
                $variables['genres'][] = $genre;
            }
        }

        return [
            'errors'    => $errors,
            'variables' => $variables
        ];

    }

    private function saveImage()
    {
        $path = "images/";
        $path = $path . basename( $_FILES['image']['name'] );
        move_uploaded_file( $_FILES['image']['tmp_name'], $path );

        return basename( $_FILES['image']['name'] );
    }


}