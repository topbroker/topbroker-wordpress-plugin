<?php
global $broker_id;

get_header();
?>

<section class="content-area">
	<div class="container tb-container">
		<?php $user = TB()->users->getItem($broker_id); ?>

		<h1><?php echo $user->name ?></h1>

		<figure>
			<img src="<?php echo $user->image_url ?>" alt="">
		</figure>

		<div>
			<a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a>
		</div>

		<div>
			<a href="tel:<?php echo $user->phone ?>"><?php echo $user->phone ?></a>
		</div>

        <?php if (isset($user->custom_fields->c_f_u_prisistatymas)): ?>
		<div>
			<p>
				<?php echo nl2br($user->custom_fields->c_f_u_prisistatymas) ?>
			</p>
		</div>
        <?php endif; ?>

	</div>
</section>

<?php get_footer() ?>
