<div class="main">
    <div class="header">
        <a href="<?= URL; ?>"><img class="logo" src="<?= URL; ?>images/logo.jpg" alt="Bookshop"/></a>
        <span><h1><p>BookShop "Modest"</p></h1></span>
    </div>
    <div id="contentwrapper">
        <div id="content">
            <?php if ( isset( $data['book'] ) ): $book = $data['book']; ?>
                <p class="center"><?= $book->name; ?></p>
                <p class="center"><img src="<?= URL; ?>/images/<?= $book->image ?>"></p>
                <p><?= $book->description ?></p>
                <p class="info">genre(s): <?= $book->genre; ?></p>
                <p class="info">author(s): <?= $book->author; ?></p>
                <p class="info">price: <?= $book->price; ?>.uah </p>

                <p>To buy this book please fill the form below, and after that we will send You further instructions about payment and shipping:</p>
                <form method="POST" id="feedback-form" action="<?= URL ?>order?book_id=<?= $book->id ?>">
                    <p><label>Your Name:
                            <input type="text" name="name" required placeholder="Albert Vesker"></label></p>
                    <p><label>Address:
                            <input type="text" name="address" required placeholder="54000 Racoon city"></label></p>
                    <p><label>Number of examples:
                            <input type="number" name="number"></label></p>
                    <p><label>Email:
                            <input type="email" name="email" required placeholder="umbrella@resident.evil"></label></p>
                    <p>Additional questions:</p>
                    <p><textarea name="message"></textarea></p>
                    <input type="submit" value="send"><br/>
                </form>

            <?php else: ?>
                <p>Book not found</p>
            <?php endif; ?>
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
<?php if ( isset( $data['email_errors'] ) || isset( $data['email_success'] ) ): ?>
    <div class="submit-message">
        <?php if ( isset( $data['email_errors'] ) ): ?>
            <?php foreach ( $data['email_errors'] as $error ): ?>
                <p><?= $error; ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= $data['email_success'] ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>