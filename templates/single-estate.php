<?php
global $estate_id;

get_header();
?>

<section class="content-area">
	<div class="container  tb-container">

		<?php $estate = TB()->estates->getItem($estate_id); ?>

		<h1><?php echo $estate->title ?></h1>

        <?php if (isset($estate->photos[0])): ?>
		<figure>
			<img src="<?php echo $estate->photos[0]->large_image_url ?>" alt="">
		</figure>
        <?php endif; ?>

		<h4><?php echo ( $estate->for_sale ? 'For Sale' : 'For Rent' ) ?></h4>

		<div>Price: <?php echo ( $estate->for_sale ? $estate->sale_price : $estate->rent_price ) ?></div>

		<p>
			<?php echo nl2br($estate->description->content) ?>
		</p>

	</div>
</section>

<?php get_footer() ?>
