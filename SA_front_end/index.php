<!DOCTYPE html>

<html lang="en">

<head>
	<title>HOME</title>
	<?php include '_head.html'; ?>
</head>

<body id="body">
	<!-- Start Top Header Bar -->
	<section class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-xs-12 col-sm-4">
					<div class="contact-number">
						<i class="archive"></i>
						<span
							style="font-size: 20px; font-weight: bold; color: #333; font-family: 'Arial', sans-serif;">惜物盲盒
							<span style="font-style: italic; font-family: 'Regular 400', sans-serif;">Mysterious
								Box
							</span>
						</span>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<!-- Site Logo -->
					<div class="logo text-center">
						<a href="index.php">
							<!-- replace logo here -->
							<svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1"
								xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
									font-size="40" font-family="AustinBold, Austin" font-weight="bold">
									<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
										<text id="AVIATO">
											<tspan x="108.94" y="325">HOME</tspan>
										</text>
									</g>
								</g>
							</svg>
						</a>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<!-- Cart -->
					<ul class="top-menu text-right list-inline">
						<li class="dropdown cart-nav dropdown-slide">
							<!-- Account Login -->
						<li class="dropdown account dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
									class="tf-ion-ios-person"></i> Account</a>
							<ul class="dropdown-menu account-dropdown">
								<div class="col-sm-3 col-xs-12">
									<ul>
										<li role="separator" class="divider"></li>
										<li><a href="login.php">Login </a></li>
										<br>
										<li><a href="signin.php">Signin</a></li>
										<br>
										<li><a href="forget-password.html">Help</a></li>
									</ul>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Slider -->
	<?php include '_buyer_slider.html'; ?>



	<section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2><strong>最新上架 New</strong></h2>
                </div>
            </div>
            <div class="row">
                <!-- Products -->
                <?php include '../SA_back_end/visiter_index.php'; ?>
            </div>
        </div>
    </section>

	<?php include '_footer.html'; ?>

	<?php include '_script.html'; ?>
</body>

</html>