<?php include('lib/header.php'); ?>
<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="<?php echo getURL('anasayfa.php'); ?>"><?php echo dil_ANASAYFA ?></a> <span class="divider">/</span></li>
						<li class="active"><?php echo dil_SSS ?></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2><?php echo dil_SSS_UZUN ?></h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="span12">
				<p class="lead"></p>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="span12">
				<section class="toggle">
					<input type="checkbox" id="q1">
					<label for="q1"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="q2">
					<label for="q2"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="a3">
					<label for="q3"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="q4">
					<label for="q4"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="q5">
					<label for="q5"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="q6">
					<label for="q6"></label>
					<p></p>
				</section>

				<section class="toggle">
					<input type="checkbox" id="q7">
					<label for="q7"></label>
					<p></p>
				</section>
			</div>
		</div>
	</div>
</div>
<?php include('lib/footer.php'); ?>