		
<!DOCTYPE html>
<html>
<head>
	<title>Track Me</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="view/user/user.js"></script>
</head>

<style type="text/css">

	html{
		margin: 0;
	}
	body{
		margin: 0;
		font-family: Arial, Helvetica, sans-serif;
		overflow-x: hidden;
	}

	.font-weight-light {
		font-size: 30px;
		margin-top: 50px;

	}

	.c1{
		/*  padding-right: 30px; */
		padding-left: 0;
		padding-right:0;
		height: 100vh;
	}
	.c2{
		background-color: #66bb6a;
		padding-right: 30px;
		padding-left: 30px;

	}
	.col0{
		margin-top: 50px;
	}
	.r1{
		margin-top: 50px;
		justify-content: center;
	}
	.btn{
		margin: 5px 0px 5px 0px;
		width: 100%;
	}
	.r2{
		justify-content: center;
		align-items: center;
	}

	.btn_last{
		margin-top: 200px;
		margin-bottom: 160px;
		width: 100%;
		align-items: center;
		font-size: 22px; 
	}
	.btn_last.btn-outline-light:hover {
		color: #66bb6a;
		background-color: #ffffff;
		border-color: #66bb6a;
	}

	@media (min-width: 768px){
		.col-md-6 {
			-ms-flex: 0 0 50%;
			flex: 0 0 50%;
			max-width: 100%;
		}
	}
	.r3{ 
		justify-content: center;
		align-items: center;

	}

	.r4{
		display: flex;
		justify-content: space-between;
		position: relative;
		padding-left: 0;
		padding-right:0;

	}


	.txt_1{
		color: #1565c0;
	}

	.col1{
		margin-top: 20%;
		align-items: center;
	}

	.btn_blu{
		background-color: #2196f3;
		height: 50px;
		font-size: 22px;
		width: 100%;
	}

	.btn_blu.btn-outline-light:hover {
		color: #2196f3;
		background-color: #ffffff;
		border-color: #2196f3;
	}


	.form-control,
	.form-control:focus {
		color:#868686 ;
	}


	.modal-title.text-center{
		color:#2196f3;
	}

	.txt_11{
		font-size: 22px;
		color: #1565c0;

	} 



	/* second-file */
	.jumbotron{
		background-color: #2196f3;
		color: white;
	}

	.con_1{
		padding-right: 0;
		padding-left: 0;
	}

	.txt_2{
		font-size: 20px;
	}

	.txt_3{
		font-weight: 600;
		font-size: 22px;

	}




	@media (max-width: 768px){
		.hidden-sm-down {
			display: none;
		}
	}


</style>
<body onload="loading()">
	<div class="container-fluid c1">
		<div class="row r0">
			<div class="col-md-6 col-sm-12 col-lg-6 ">
				<div class=" container-fluid c2">
					<div class="row r2">
						<div class="col-md-12 col-lg-12 col-sm-12 col0">
							<img src="view/user/images/Group29.png" alt="Bus Image" class="float-left" width="150px">
							<div class="font-weight-light text-center text-white">Zgjidh Autobusin Tend!</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="row r1" >
								<div class="col-md-6 col-lg-6 col-sm-12">
									<div class="row">
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Kombinat" class=" btn btn-outline-success btn-light"  onClick="busMap(this.id)">Kombinat</button>
										</div>
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Tirana e Re" class=" btn btn-outline-success btn-light" onclick="busMap(this.id)">Tirana e Re</button>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Unaza" class=" btn btn-outline-success btn-light" onclick="busMap(this.id)">Unaza</button>
										</div>
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Vore" class=" btn btn-outline-success btn-light" onclick="busMap(this.id)">Vore</button>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Kristal" class=" btn btn-outline-success btn-light" onclick="busMap(this.id)">Kristal</button>
										</div>
										<div class="col-md-6 col-lg-6 col-sm-12">
											<button id="Qtu" class=" btn btn-outline-success btn-light" onclick="busMap(this.id)">QTU</button>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-lg-6 col-sm-12">
											<!-- <button class=" btn btn-outline-success btn-light" onclick="busMap()">TEG</button> -->
										</div>
										<div class="col-md-6 col-lg-6 col-sm-12">
											<!-- <button class=" btn btn-outline-success btn-light" >Kombinat</button> -->
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-lg-6 col-sm-12">
											<!-- <button class=" btn btn-outline-success btn-light ">Kombinat</button> -->
										</div>
										<div class="col-md-6 col-lg-6 col-sm-12">
											<!-- <button class=" btn btn-outline-success btn-light ">Kombinat</button> -->
										</div>
									</div>
									<div class="row r3">
										<div class="col-md-12 col-lg-12 col-sm-12">
											<div class="btn btn-outline-light btn-success btn_last" >
												Shiko ne harte.
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-lg-6">
				<div class="container-fluid ">
					<div class="row r4">
						<div class="col-md-12 col-lg-12 col-sm-12 col1">
							<div class="font-weight-light text-center txt_1">Nuk di ke autobus te marresh?!</div>
							<button class="btn btn-outline-light btn-success btn_blu" data-toggle="modal" data-target="#myModal">Gjej autobusin tend!</button>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col1">
							<img src="view/user/images/Group30.png" width="299px" class="float-right">
						</div>
					</div>

					<!-- modal -->
					<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Modal Header -->

								<div class="modal-header ">
									<h4 class="modal-title text-center">Gjej autobusin tend:</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Modal body -->

								<div class="modal-body">
									<div class="form-group">
										<label for="sel1" class="txt_11">Mberritja:</label>
										<textarea cols="55" rows="1" id="address"></textarea>
										<!-- <button class="btn btn-outline-light btn-success btn_blu" onclick="getLocation()">Perdor vendodhjen tende aktuale</button> -->
										<p id="message"></p>
						      	          <!--  <select class="form-control" id="sel1">
						      	             <option class="txt_1">Kombinat</option>
						      	             <option class="txt_1">KOmbinat</option>
						      	             <option class="txt_1">KOmbinat</option>
						      	             <option class="txt_1">Kombinat</option>
						      	         </select> -->
						      	     </div>
						      	<!--      <div class="form-group">
						      	     	<label for="sel1" class="txt_11">Mberritja:</label>
						      	     	<textarea cols="55" rows="1"></textarea>
						      	     </div> -->
						      	 </div>

						      	 <!-- Modal footer -->

						      	 <div class="modal-footer">
						      	 	<button type="button" class="btn btn-outline-light btn-success btn_blu"  onclick="map()">Perdor vendodhjen tende aktuale</button>
						      	 </div>

						      	</div>
						      </div>
						  </div>
						</div>
					</div>

				</div>
			</div>
		</body>

<!-- <script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBThtUxHddy0bE1KSe8K4DHtgAimxHobF8&callback=initMap">
</script> -->
</html>


