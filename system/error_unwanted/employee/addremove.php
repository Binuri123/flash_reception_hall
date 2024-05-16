<!doctype html>
<html lang="en">

<head>
	<title></title>
	<link rel="stylesheet" href=
"//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href=
"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>

	<style>
		body {
			display: flex;
			flex-direction: column;
			margin-top: 1%;
			justify-content: center;
			align-items: center;
		}

		#rowAdder {
			margin-left: 17px;
		}
	</style>
</head>

<body>
	<?php
	
	 @$fields=$_REQUEST['field_name'];
	 //print_r($fields);
    
	 foreach($fields as $val){
		echo $val;
	 }

	
   ?>
	
	

	<div style="width:40%;">

		<form>
			<div class="">
				<div class="col-lg-12">
					<div id="row">
						<div class="input-group m-3">
							<div class="input-group-prepend">
								<button class="btn btn-danger"
									id="DeleteRow" type="button">
									<i class="bi bi-trash"></i>
									Delete
								</button>
							</div>
							    <input type="text" name="field_name[]" class="form-control m-input" id="result1">
                                <input type="text" class="form-control n-input">   
                                <input type="text" class="form-control p-input"> 
								
						</div>
					</div>

					<div id="newinput"></div>
					<button id="rowAdder" type="button"
						class="btn btn-dark">
						<span class="bi bi-plus-square-dotted">
						</span> ADD
					</button>
					<input type="submit" name='submit'> 
				</div>
			</div>
		</form>
	</div>

	<script type="text/javascript">

		$("#rowAdder").click(function () {
			newRowAdd =
			'<div id="row"> <div class="input-group m-3">' +
			'<div class="input-group-prepend">' +
			'<button class="btn btn-danger" id="DeleteRow" type="button">' +
			'<i class="bi bi-trash"></i> Delete</button> </div>' +
			'<input type="text" name="field_name[]" class="form-control m-input"> <input type="text" class="form-control n-input"> <input type="text" class="form-control p-input"></div> </div>';

			$('#newinput').append(newRowAdd);

            $res=$("#result1").val();
           
		});

		$("body").on("click", "#DeleteRow", function () {
			$(this).parents("#row").remove();
		})
	</script>
</body>

</html>
