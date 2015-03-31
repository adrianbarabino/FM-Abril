			<aside class="pageSidebar sidebar">
				<section class="sideblock">
					<h2>Meteorologia</h2>
					<div id="weather" style="background:url('icon<?php echo $ampm; ?>.png')">
					    <div id="current" style="background:url('http://l.yimg.com/us.yimg.com/i/us/nws/weather/gr/<?php echo $icon.$ampm.".png"; ?>')">
					    <div id="datostiempo" style="background: #303030;opacity: 0.7;float: right;padding: 10px;">
					        <div id="temp"><?php echo $weather->get_temperature(); ?>&deg;<?php echo $unit; ?></div>
					        <div id="fore"><?php echo $fore[0]->get_low()."&deg;".$unit; ?> - <?php echo $fore[0]->get_high()."&deg;".$unit; ?></div>
					        <div id="fore"><?php echo $weather->get_wind_speed(); ?> km/h <?php echo $weather->get_wind_direction(); ?> </div>
					                                <div id="fore"><?php echo $weather->get_pressure(); ?> hPa</div>
					                                                <div id="fore"><?php echo $weather->get_humidity(); ?>% H</div>


					        </div>
					    </div>
					</div>							
				</section>
			</aside>