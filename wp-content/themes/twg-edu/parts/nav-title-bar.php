<div class="title-bar hide-for-large" data-responsive-toggle="header-bar" data-hide-for="large">
	<div class="menu-toggle">
		<div class="open" data-toggle>
			<div class="menu-line"></div>
			<div class="menu-line"></div>
			<div class="menu-line"></div>
		</div>
	</div>

    <div class="logo-container">
        <a href="<?php echo bloginfo('url'); ?>">
            TWG EDU
        </a>
    </div>
</div>

<div class="header-bar" 
    id="header-bar" 
    data-closable data-animate="slide-in-right fast slide-out-right fast" 
    data-show-for="large"
    >
	<div class="close hide-for-large" data-close="header-bar"></div>

    <div class="logo-container">
        <a href="<?php echo bloginfo('url'); ?>">
           TWG EDU
        </a>
    </div>
	
	<div class="menu-wrap">
		<?php 
			wp_nav_menu( array( 
				'menu' => 'Main'
			)); 
		?>
	</div>
</div>

