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
                    <?php if ( isset( $data['book'] ) ): $book = $data['book']; ?>
                        <?php if ( empty( $data['authors'] ) ): ?>
                            <p>First add authors</p>
                        <?php elseif ( empty( $data['genres'] ) ): ?>
                            <p>First add genres</p>
                        <?php else: ?>
                            <form method="POST" action="<?= URL ?>/admin/books/update" enctype="multipart/form-data">
                                <input type="hidden" name="book_id" value="<?= $book->id; ?>">
                                <p><label>
                                        name<input type="text" name="name" value="<?= $book->name; ?>">
                                </p></label>
                                <p><label>
                                        description<textarea name='description'>
                                    <?= $book->description; ?>
							</textarea>
                                </p></label>
                                <p><label>
                                        price<input type="number" name="price" value="<?= $book->price; ?>">
                                </p></label>
                                <p><label>
                                        year<input type="text" name="year" value="<?= $book->year; ?>">
                                </p></label>
                                <p><label>
                                        image<input type="file" name="image">
                                        <img src="<?= URL ?>images/<?= $book->image ?>" alt="">
                                </p></label>
                                <p>
                                    <select multiple name='authors[]'>
                                        <?php foreach ( $data['authors'] as $author ): ?>
                                            <option <?php if ( in_array( $author->name, $book->authors ) ) {
                                                echo 'selected';
                                            } ?> value="<?= $author->id ?>"><?= $author->name ?></option>
                                        <?php endforeach; ?>
                                    </select></p>
                                <p><select multiple name='genres[]'>
                                        <?php foreach ( $data['genres'] as $genre ): ?>
                                            <option <?php if ( in_array( $genre->name, $book->genres ) ) {
                                                echo 'selected';
                                            } ?> value="<?= $genre->id ?>"><?= $genre->name ?></option>
                                        <?php endforeach; ?>
                                    </select></p>
                                <p><input type="submit" value="Save"></p>
                            </form>
                        <?php endif; ?>
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

<?php if ( isset( $data['errors'] ) || isset( $data['success_massage'] ) ): ?>
    <div class="submit-message">
        <?php if ( isset( $data['errors'] ) ): ?>
            <?php foreach ( $data['errors'] as $error ): ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= $data['success_massage'] ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>