<?php

class AuthorsController extends Controller
{
    public function index()
    {
        $authors = new AuthorModel();
        $authors     = $authors->getAuthors();

        $data = [
            'title'  => 'Manage authors',
            'authors' => $authors
        ];

        $this->loadView( 'admin/authors', $data );
    }

    public function edit()
    {
        if ( ! isset( $_GET['author_id'] ) ) {
            header( 'Location:' . URL . '/admin/authors' );
        }

        $authorId = trim( $_GET['author_id'] );
        $authorId = strip_tags( $authorId );

        $authorModel = new AuthorModel();
        $author      = $authorModel->getAuthorById( $authorId );

        $data = [
            'title' => 'Edit author',
            'author' => $author
        ];

        $this->loadView( 'admin/edit_author', $data );
    }

    public function add()
    {
        $data = [
            'title' => 'Add author',
        ];

        $this->loadView( 'admin/add_author', $data );
    }

    public function update()
    {
        if ( ! isset( $_POST['author_id'] ) ) {
            header( 'Location:' . URL . '/admin/authors' );
        }

        $authorId = $_POST['author_id'];


        $authorModel = new AuthorModel();

        $authorModel->updateAuthorById( $authorId, $_POST['name'] );

        $author = $authorModel->getAuthorById( $authorId );

        $data = [
            'title'           => 'Edit author',
            'author'           => $author,
            'success_message' => 'author updated'
        ];

        $this->loadView( 'admin/edit_author', $data );
    }

    public function save()
    {
        if ( ! isset( $_POST['submit'] ) ) {
            header( 'Location: ' . URL . 'admin/genres/add' );
        }

        $authorModel = new AuthorModel();
        $authorModel->saveAuthor( $_POST['name'] );
        header( 'Location: ' . URL . 'admin/authors' );
    }

    public function delete()
    {
        $authorId = trim( $_GET['author_id'] );
        $authorId = strip_tags( $authorId );

        if ( empty( $authorId ) || ! is_numeric( $authorId ) ) {
            $data = [
                'errors' => 'not valid id'
            ];
        }else{
            $authorModel = new AuthorModel();
            $result     = $authorModel->deleteAuthorById( $authorId );

            if ( $result ) {
                $data = [
                    'message' => 'author deleted',
                ];
            } else {
                $data = [
                    'errors' => "author wasn't deleted",
                ];
            }
        }

        $authorModel = new AuthorModel();
        $authors     = $authorModel->getAuthorById();

        $data = array_merge( [
            'title'  => 'Manage authors',
            'authors' => $authors
        ], $data );

        $this->loadView( 'admin/authors', $data );
    }
}