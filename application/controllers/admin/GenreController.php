<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.01.2019
 * Time: 20:18
 */

class GenreController extends Controller
{
    public function index()
    {
        $genreModel = new GenreModel();
        $genres     = $genreModel->getGenres();

        $data = [
            'title'  => 'Manage genres',
            'genres' => $genres
        ];

        $this->loadView( 'admin/genres', $data );
    }

    public function edit()
    {
        if ( ! isset( $_GET['genre_id'] ) ) {
            header( 'Location:' . URL . '/admin/genres' );
        }

        $genreId = trim( $_GET['genre_id'] );
        $genreId = strip_tags( $genreId );

        $genreModel = new GenreModel();
        $genre      = $genreModel->getGenreById( $genreId );

        $data = [
            'title' => 'Edit genre',
            'genre' => $genre
        ];

        $this->loadView( 'admin/edit_genre', $data );
    }

    public function add()
    {
        $data = [
            'title' => 'Add genre',
        ];

        $this->loadView( 'admin/add_genre', $data );
    }

    public function update()
    {
        if ( ! isset( $_POST['genre_id'] ) ) {
            header( 'Location:' . URL . '/admin/genres' );
        }

        $genreId = $_POST['genre_id'];


        $genreModel = new GenreModel();

        $genreModel->updateGenreById( $genreId, $_POST['name'] );

        $genre = $genreModel->getGenreById( $genreId );

        $data = [
            'title'           => 'Edit genre',
            'genre'           => $genre,
            'success_message' => 'genre updated'
        ];

        $this->loadView( 'admin/edit_genre', $data );
    }

    public function save()
    {
        if ( ! isset( $_POST['submit'] ) ) {
            header( 'Location: ' . URL . 'admin/genres/add' );
        }

        $genreModel = new GenreModel();
        $genreModel->saveGenre( $_POST['name'] );
        header( 'Location: ' . URL . 'admin/genres' );
    }

    public function delete()
    {
        $genreId = trim( $_GET['genre_id'] );
        $genreId = strip_tags( $genreId );

        if ( empty( $genreId ) || ! is_numeric( $genreId ) ) {
            $data = [
                'errors' => 'not valid id'
            ];
        }else{
            $genreModel = new GenreModel();
            $result     = $genreModel->deleteGenreById( $genreId );

            if ( $result ) {
                $data = [
                    'message' => 'genre deleted',
                ];
            } else {
                $data = [
                    'errors' => "genre wasn't deleted",
                ];
            }

            $genreModel = new GenreModel();
            $genres     = $genreModel->getGenres();
        }

        $data = array_merge( [
            'title'  => 'Manage genres',
            'genres' => $genres
        ], $data );

        $this->loadView( 'admin/genres', $data );
    }

}