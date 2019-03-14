<?php get_header() ?>

<section class="content-area">
	<div class="container tb-container">

		<div class="tb-filter">
			<form action="" method="get">
                <div>
                <input type="hidden" name="action" value="search_estate">
                <label>
                    Manucipality
                    <select name="municipality_id">
                        <?php foreach ( TB()->locations->getMunicipalities(['estate_type' => $_REQUEST['estate_type'] ?? 'flat']) as $municipality ): ?>
                            <option value="<?php echo $municipality->id ?>"><?php echo $municipality->name ?></option>
                        <?php endforeach ?>
                    </select>
                </label>
				<label>
					Estate type
					<select name="estate_type">
						<option value="flat" selected>Butai</option>
						<option value="house">Namai</option>
						<option value="commercial">Kom. Patalpos</option>
					</select>
				</label>
                <label>
                    Area min
                    <input type="number" name="area_min" value="<?php echo $_REQUEST['area_min'] ?>">
                </label>
                <label>
                    Area max
                    <input type="number" name="area_max" value="<?php echo $_REQUEST['area_max'] ?>">
                </label>
                </div>
				<button type="submit">Search</button>
			</form>
		</div>

		<div class="tb-list">
            <?php
            $params = [
                'municipality_id' => $_REQUEST['municipality_id'] ?? '',
                'estate_type' => $_REQUEST['estate_type'] ?? 'flat',
                'area_min' => $_REQUEST['area_min'] ?? '',
                'area_max' => $_REQUEST['area_max'] ?? '',
                'per_page' => 8,
                'page' => $_REQUEST['pg'] ?? 1,
            ];
            foreach( TB()->estates->getList($params) as $estate ) :
                ?>
                <div class="tb-card">
                    <a href="<?php echo Top_Broker_Public::get_permalink($estate,'estate') ?>">
                        <figure>
                            <img src="<?php echo $estate->primary_photo ?>" alt="" width="220">
                        </figure>
                        <main class="tb-card-body">
                            <?php if($estate->title): ?>
                                <h3><?php echo $estate->title ?></h3>
                            <?php endif ?>
                        </main>
                        <footer class="tb-card-footer">
                            <span>Price <?php echo $estate->sale_price ?>&euro;</span>
                            <span>Area <?php echo $estate->square_sale_price ?>&euro;/m2</span>
                        </footer>
                    </a>
                </div>
            <?php endforeach ?>
		</div>

        <div class="tb-pagination">
            <?php Top_Broker_Public::get_pagination($params) ?>
        </div>

	</div>
</section>

<?php get_footer() ?>
