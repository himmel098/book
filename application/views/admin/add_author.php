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
                    <form method="POST" action="<?= URL ?>admin/authors/save" enctype="multipart/form-data">
                        <p><label>
                                name<input type="text" name="name">
                        </p></label>
                        <p><input type="submit" value="Save"></p>
                    </form>
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