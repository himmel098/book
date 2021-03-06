<div class="main">
    <div class="header">
        <a href="/"><img class="logo" src="<?= URL; ?>images/logo.jpg" alt="Bookshop"/></a>
        <h1><p>BookShop</p></h1>

    </div>
    <div id="contentwrapper">
        <div id="content">
            <div class="catalog-index">
                <div class="product-index">
                    <h1>Admin Panel</h1>
                    <?php if ( isset( $data['authors'] ) ): ?>
                        <table>
                            <?php foreach ( $data['authors'] as $author ): ?>
                                <tr>
                                    <td><?= $author->name; ?></td>
                                    <td><a href="<?= URL ?>admin/authors/edit?author_id=<?= $author->id ?>">Edit</a></td>
                                    <td><a href="<?= URL ?>admin/authors/delete?author_id=<?= $author->id ?>">DELETE</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>


                    <?php else: ?>
                        <p>List of authors not received</p>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>
    <div id="left-bar">
        <div>
            <p align="center" class="title">Books</p>
            <div id="coolmenu">
                <p><a href="<?= URL ?>admin/books/add">Add</a></p>
                <p><a href="<?= URL ?>admin/books">Edit / Delete</a></p>

            </div>

            <p align="center" class="title">Genres</p>
            <div id="coolmenu">
                <p><a href="<?= URL ?>admin/genres/add">Add</a></p>
                <p><a href="<?= URL ?>admin/genres">Edit / Delete</a></p>
            </div>

            <p align="center" class="title">Authors</p>
            <div id="coolmenu">
                <p><a href="<?= URL ?>admin/authors/add">Add</a></p>
                <p><a href="<?= URL ?>admin/authors">Edit / Delete</a></p>
            </div>
        </div>

    </div>
</div>