<?php get_header() ?>

<section class="content-area">
    <div class="container tb-container">

        <div class="tb-list">
            <?php foreach( TB()->users->getList() as $user ) : ?>
                <div class="tb-card">
                    <a href="<?php echo Top_Broker_Public::get_permalink($user,'user') ?>">
                        <figure>
                            <img src="<?php echo $user->image_url ?>" alt="" width="220">
                        </figure>
                        <main class="tb-card-body">
                            <?php if($user->name): ?>
                                <h3><?php echo $user->name ?></h3>
                            <?php endif ?>
                        </main>
                        <footer class="tb-card-footer">
                            <span>Phone <?php echo $user->phone ?></span>
                            <span>Email <?php echo $user->email ?></span>
                        </footer>
                    </a>
                </div>
            <?php endforeach ?>
        </div>

    </div>
</section>

<?php get_footer() ?>
