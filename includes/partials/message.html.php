<?php if(isset($_SESSION['message'])) : ?>
	<div class="alert alert-danger" role="alert">
		<?php echo $_SESSION['message']; ?>
		<?php unset($_SESSION['message']) ?>
	</div>
<?php endif; ?>

<?php if(isset($_SESSION['message-success'])) : ?>
	<div class="alert alert-success" role="alert">
		<?php echo $_SESSION['message-success']; ?>
		<?php unset($_SESSION['message-success']) ?>
	</div>
<?php endif; ?>