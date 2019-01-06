<div class="main">
    <div class="header">
        <a href="<?= URL; ?>"><img class="logo" src="<?= URL; ?>images/logo.jpg" alt="Bookshop"/></a>
        <span><h1><p>BookShop "Modest"</p></h1></span>
    </div>
    <div id="contentwrapper">
        <div id="content">
            <div class="catalog-index">
                <?php if ( ! empty( $data['books'] ) ): ?>
                    <h2><?= $data['current_genre']->name; ?> Books</h2>
                    <div class="product-index">
                        <?php foreach ( $data['books'] as $book ): ?>
                            <p><a href="<?= URL; ?>books?book_id=<?= $book->id; ?>"><?= $book->name; ?>
                            <p><img src='<?= URL; ?>images/<?= $book->image; ?>'></p></a></p>
                            <p>Price: <?= $book->price; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>List of <?= $data['current_author']->name; ?> books not received</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="left-bar">

        <div class="info">
            <h3>Authors:</h3>
            <?php if ( ! empty( $data['authors'] ) ): ?>
                <?php foreach ( $data['authors'] as $author ): ?>
                    <p><a href="<?= URL; ?>authors?author_id=<?= $author->id; ?>"><?= $author->name; ?></a></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>List of Authors not received</p>
            <?php endif; ?>

        </div>
        <div class="info">
            <h3>Genres:</h3>
            <?php if ( ! empty( $data['genres'] ) ): ?>

                <?php foreach ( $data['genres'] as $genre ): ?>
                    <p><a href="<?= URL; ?>genres?genre_id=<?= $genre->id ?>"><?= $genre->name; ?></a></p>
                <?php endforeach; ?>

            <?php else: ?>
                <p>List of Genres not received</p>
            <?php endif; ?>

        </div>
        <div class="info">
            <h3>ADMIN:</h3>
            <a href="<?= URL; ?>admin">Administrator</a>
        </div>
    </div>
</div>