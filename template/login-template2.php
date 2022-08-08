<div id="template-bg-1">
	<div
		class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
		<img src="/images/logo.png" alt="" width="172" height="77">
		<div class="card p-4 mb-5">
			<div class="card-header" style="background-color: white;">
				<h3><a href="/" style="text-decoration: none"><</a> Регистрация</h3>
			</div>
			<div class="card-body w-100">
				<form name="login" action="" method="post">
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-user mt-2"></i></span>
						</div>
						<input type="text" class="form-control" <?php if (!empty($_POST["username"])){echo("value=\"".$_POST["username"]."\"");} ?> placeholder="Почта"
							name="username" required>
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-key mt-2"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Пароль"
							name="password" required>
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-key mt-2"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Повтор пароля"
							name="repassword" required>
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-phone mt-2"></i></span>
						</div>
						<input type="text" class="form-control" <?php if (!empty($_POST["phone"])){echo("value=\"".$_POST["phone"]."\"");} ?> placeholder="Телефон"
							name="phone" required>
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-columns mt-2"></i></span>
						</div>
						<input type="text" class="form-control" <?php if (!empty($_POST["company"])){echo("value=\"".$_POST["company"]."\"");} ?> placeholder="Название компании"
							name="company"  required>
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-building mt-2"></i></span>
						</div>
						<input type="text" class="form-control" <?php if (!empty($_POST["object"])){echo("value=\"".$_POST["object"]."\"");} ?> placeholder="Название объекта или адрес"
							name="object" required>
					</div>

					<div class="form-group mt-3">
						<input type="submit" value="Зарегистрироваться"
							class="btn bg-primary float-end text-white w-100"
							name="reg-btn">
					</div>
				</form>
                <?php if(!empty($loginResult)){?>
				<div class="text-danger"><?php echo $loginResult;?></div>
				<?php }?>
			</div>
			<div class="alert alert-warning" role="alert">
			Бесплатно выдаются только 3 лицензии на <a href="https://true-ip.ru/catalog/po/beta-versiya-programmi-ti-concierge">TI-Concierge</a>.
</div>
			
		</div>
	</div>
</div>
