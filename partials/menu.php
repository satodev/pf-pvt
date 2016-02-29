<div class="title-bar hide-for-medium" data-responsive-toggle="pf_menu" data-hide-for="medium">
	<button class="menu-icon" type="button" data-toggle></button>
	<div class="title-bar-title">Menu</div>
</div>
<div id='pf_menu' class="top-bar">
<h1>PVT | Portfolio</h1>

	<div class="top-bar-left">
		<ul class="menu">
	<li><a href="?p=home">Accueil</a></li>
	<li><a href="?p=portfolio">Portfolio</a></li>
	<li><a href="?p=contact">Contact</a></li>
	</ul>
	</div>
	
	<?php
		session_start();
		if($_SESSION['sSession']){
			?>
			<div class="top-bar-right">
          <ul class="menu">
          	<li><a href="/?p=back">Back</a></li>
           <li><a href="/?p=back&d=true">Déconnecter</a></li>
          </ul>
        </div>
			
		<?php
		}
		?>
</div>
