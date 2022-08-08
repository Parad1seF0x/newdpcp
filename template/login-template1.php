<div id="template-bg-1">
	<div
		class="d-flex flex-column min-vh-100 justify-content-center  align-items-center">
		<img src="/images/logo.png" alt="" width="172" height="77">
		<div class="card p-4 mb-5">
			<div class="card-header" style="background-color: white;">
				<h3>Вход</h3>
			</div>
			<div class="card-body w-100">
				<form name="login" action="" method="post">
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-user mt-2"></i></span>
						</div>
						<input type="text" name="tel" value="<?php echo($_GET['tel_num']) ?>" hidden>
						<input type="text" class="form-control" placeholder="Почта"
							name="username">
					</div>
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-key mt-2"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Пароль"
							name="password">
					</div>

					<div class="form-group mt-3">
						<input type="submit" value="Войти"
							class="btn bg-primary float-end text-white w-100"
							name="login-btn">
					</div>
					
				</form>
                <?php if(!empty($loginResult)){?>
				<div class="text-danger"><?php echo $loginResult;?></div>
				<?php }?>
			</div>
			<div class="card-footer" style="background-color: white;">
				<div class="d-flex justify-content-center">
					<div class="text-primary"><a href="?action=reg">У меня нет аккаунта.</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
