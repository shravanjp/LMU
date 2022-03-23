<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required="" type="email">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" required="">
		</div>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
			</select>
		</div>
	</form>
</div>
<script>
	$('#manage-user').submit(function(e){
		e.preventDefault();

		$('#manage-user button[type="button"]').attr('disabled', true);

		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();

		// start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				
				if(resp == 0){
					$('#manage-user').prepend('<div class="alert alert-danger">Please fill out the complete form</div>');
					$('#button[type="button"]').removeAttr('disabled').html('Login');
				}
				else if(resp == 1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else if(resp==2){
					console.log(resp);
					$('#manage-user').prepend('<div class="alert alert-danger">Email/Username already exist</div>');
					$('#button[type="button"]').removeAttr('disabled').html('Login');
				}else{
					console.log(resp);
					$('#manage-user').prepend('<div class="alert alert-danger"> Invalid email format</div>');
					$('#button[type="button"]').removeAttr('disabled').html('Login');
				}
				
			}
		})
	})
</script>