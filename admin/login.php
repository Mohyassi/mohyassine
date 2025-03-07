<!DOCTYPE html>
<html lang="en">
<?php 

session_start();
if(isset($_SESSION['login_admin_id'])){
	header('Location:index.php?page=home');
}
include 'header.php';
 ?>

<body>
	<main>
		
		<div class="container-fluid">
			
			<div class="col-lg-12">
				<div class="row">
					<div class="col-md-4 offset-4 card">
						<div class="card-body">
							<form action="" id="login-frm">
								<div class="form-group">
									<label for="username" class="control-label">Username</label>
									<input type="text" name="username" id="username" class="form-control">
								</div>
								<div class="form-group">
									<label for="password" class="control-label">Password</label>
									<input type="password" name="password" id="password" class="form-control">
								</div>
								<center>
									<button class="btn btn-block col-md-3 btn-primary">Login</button>
								</center>

							</form>
						</div>
					</div>
				</div>
			</div>

		</div>

	</main>
	<?php //include 'footer.php' ?>
	
</body>

<script>
	$(document).ready(function(){
		$('#login-frm').submit(function(e){
			e.preventDefault()
			start_load()
			$.ajax({
				url:'authenticate.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
				},
				success:function(resp){
					if(resp == 1){
						location.replace('index.php?page=home')
					}
				}
			})
		})
	})
	window.start_load = function(){
		$('body').append('<div id="preloader2"></div>');
	}
	window.end_load = function(){
		$('body #preloader2').remove();
	}
</script>
</html>