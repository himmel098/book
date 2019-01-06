<?php


class BooksController extends Controller
{
    public function index()
    {

        if ( ! isset( $_GET['book_id'] ) ) {
            header( 'Location:' . URL );
        }

        $bookId = trim( $_GET['book_id'] );
        $bookId = strip_tags( $bookId );

        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthors();

        $bookModel = new BookModel();
        $book      = $bookModel->getBookById( $bookId );

        $genreModel = new GenreModel();
        $genres     = $genreModel->getGenres();

        $data = [
            'title'   => $book->name,
            'authors' => $authors,
            'book'    => $book,
            'genres'  => $genres
        ];

        if ( isset( $_POST['submit'] ) ) {
            $result = $this->sendOrderEmail();
            if ( $result !== true ) {
                $data['email_errors'] = $result;
            } else {
                $data['email_success'] = 'Email was successfully sent';
            }
        }

        $this->loadView( 'single_book', $data );

    }

    private function sendOrderEmail()
    {
        $bookModel = new BookModel();
        $errors    = $this->validateForm( $_POST );

        if ( ! empty( $errors ) ) {
            return $errors;
        }

        $book = $bookModel->getBookById( $_GET['book_id'] );

        mail( 'sasha@gmail.kac',
            "was filled from " . $_SERVER['HTTP_REFERER'],
            "
                Название книги: " . $book->name . "
                Имя: " . strip_tags( trim( $_POST['name'] ) ) . "\nEmail: "
            . strip_tags( trim( $_POST['contact'] ) ) . "\nКоличество: "
            . strip_tags( trim( $_POST['number'] ) ) . "\nАдресс доставки: "
            . strip_tags( trim( $_POST['address'] ) ) . "\nСообщение: "
            . strip_tags( trim( $_POST['message'] ) ) );

        return true;
    }

    private function validateForm( )
    {

        $errors = [];

        $name = trim( $_POST['name'] );
        $name = strip_tags( $name );
        if ( strlen( $name ) < 2 || strlen( $name ) > 150 ) {
            $errors['name'] = 'Name length must be more 2 and less then 150';
        }

        $message = trim( $_POST['message'] );
        $message = strip_tags( $message );
        if ( strlen( $message ) < 0 || strlen( $message ) > 2000 ) {
            $errors['message'] = 'Message length must be less then 2000';
        }

        $number = trim( $_POST['number'] );
        $number = strip_tags( $number );
        if ( ! is_numeric( $number ) ) {
            $errors['number'] = 'Examples must be numeric more then 0';
        }

        $email = trim( $_POST['email'] );
        $email = strip_tags( $email );
        if ( ! preg_match( "/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $email ) ) {
            $errors['email'] = 'Not valid email';
        }

        $address = trim( $_POST['address'] );
        $address = strip_tags( $address );
        if ( strlen( $address ) < 5 || strlen( $address ) > 2000 ) {
            $errors['address'] = 'Address length must be more 5 and less then 2000';
        }

        return $errors;
    }

}