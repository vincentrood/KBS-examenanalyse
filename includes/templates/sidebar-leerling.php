<div class="sidebar-wrapper">
	<ul class="sidebar-nav list-unstyled">
		<li>
			<a class="<?php if ($pagename == "dashboard"){echo "active-nav";}?>" href="<?php echo BASE_URL; ?>dashboard/">Dashboard</a>
		</li>
		<li>
			<a class="<?php if ($pagename == "examens"){echo "active-nav";}?>" href="<?php echo BASE_URL; ?>dashboard/">Examens</a>
		</li>
		<li>
			<a class="<?php if ($pagename == "resultaten"){echo "active-nav";}?>" href="<?php echo BASE_URL; ?>dashboard/">Resultaten</a>
		</li>
		<li>
			<a class="<?php if ($pagename == "score"){echo "active-nav";}?>" href="<?php echo BASE_URL; ?>dashboard/">Score</a>
		</li>
	</ul>
	<ul class="sidebar-nav settings-nav list-unstyled">
		<li>
			<a href="<?php echo BASE_URL; ?>includes/settings.php">Settings</a>
		</li>
		<li>
			<a href="<?php echo BASE_URL; ?>includes/logout.php">Uitloggen</a>
		</li>
	</ul>
</div>