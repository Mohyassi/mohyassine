 <?php
include("../db.php");

include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
        
        <div class="col-lg-12">
        	<div class="row">
        		
        	
         <div class="col-md-6">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Category List</h4>
                
              </div>
              <div class="card-body">
                <div class="col-md-4 offset-md-9"> <a class=" btn btn-primary " href="javascript:void(0)" id="newcat">Add New</a></div> 
                <br>
                <div class="table-responsive ps">
                  <table class="table table-striped " id="brand">
                    <thead class="">
                      <tr>
                        <th>Catyegory</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $result=mysqli_query($con,"select * from categories order by cat_title asc");

                        while(list($cat_id,$cat_title)=mysqli_fetch_array($result))
                        {
                        echo "<tr>
                        <td>$cat_title</td>
                        <td>
                        <a class=' btn btn-primary btn-sm edit_cat' href='javascript:void(0)' data-id ='$cat_id'>Edit</a>
                        <a class=' btn btn-danger btn-sm remove_cat' href='javascript:void(0)' data-id ='$cat_id'>Delete</a>
                        </td></tr>";
                        }

                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
            
           

          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Brand List</h4>
                
              </div>
              <div class="card-body">
                <div class="col-md-4 offset-md-9"> <a class=" btn btn-primary " href="javascript:void(0)" id="newbrand">Add New</a></div> 
                <br>
                <div class="table-responsive ps">
                  <table class="table table-striped " id="cat">
                    <thead class="">
                      <tr>
                        <th>Catyegory</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $result=mysqli_query($con,"select * from brands order by brand_title asc");

                        while(list($brand_id,$brand_title)=mysqli_fetch_array($result))
                        {
                        echo "<tr>
                        <td>$brand_title</td>
                        <td>
                        <a class=' btn btn-primary btn-sm edit_brand' href='javascript:void(0)' data-id ='$brand_id'>Edit</a>
                        <a class=' btn btn-danger btn-sm remove_brand' href='javascript:void(0)' data-id ='$brand_id'>Delete</a>
                        </td></tr>";
                        }

                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
            
           

          </div>
          
          </div>
        </div>
        </div>
      </div>

      <div class="modal fade" id="catmodal">
  		<div class="modal-dialog ">
      		<div class="modal-content">
      			<div class="modal-header">
      				<h5 class="modal-title">New Category</h5>
      			</div>
      			<div class="modal-body">
      				<div class="container-fluid">
      					<form action="" id="catfrm">
      					<input type="hidden" name="id">
      					<div class="form-group">
      						<label for="" class="control-label">Category Name</label>
      						<input type="text" name="name" class="form-control">
      					</div>
      					</form>
      				</div>

      			</div>
      			<div class="modal-footer">
      				 <button type="button" class="btn btn-primary" id='submit' onclick="$('#catmodal form').submit()">Save</button>
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      			</div>
      		</div>
      	</div>
      </div>
      <div class="modal fade" id="brandmodal">
  		<div class="modal-dialog ">
      		<div class="modal-content">
      			<div class="modal-header">
      				<h5 class="modal-title">New Brand</h5>
      			</div>
      			<div class="modal-body">
      				<div class="container-fluid">
      					<form action="" id="brandfrm">
      					<input type="hidden" name="id">
      					<div class="form-group">
      						<label for="" class="control-label">Brand Name</label>
      						<input type="text" name="name" class="form-control">
      					</div>
      					</form>
      				</div>

      			</div>
      			<div class="modal-footer">
      				 <button type="button" class="btn btn-primary" id='submit' onclick="$('#brandmodal form').submit()">Save</button>
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      			</div>
      		</div>
      	</div>
      </div>


      <script>
        $('#cat').dataTable()
        $('#brand').dataTable()
        $('#newcat').click(function(){


			$('#catfrm [name="id"]').val('')
			$('#catfrm [name="name"]').val('')
			$('#catmodal .modal-title').html('New Category')
        	$('#catmodal').modal('show')
        })
         $('#newbrand').click(function(){


			$('#brandfrm [name="id"]').val('')
			$('#brandfrm [name="name"]').val('')
			$('#brandmodal .modal-title').html('New Brand')
        	$('#brandmodal').modal('show')
        })
        $('#catfrm').submit(function(e){
        	e.preventDefault()
        	start_load()
        	$.ajax({
        		url:'managecat.php',
        		method:"POST",
        		data:$(this).serialize(),
        		error:err=>console.log(err),
        		success:function(resp){
        			if(resp == 1){
        				alert("Data successfully saved");
        				location.reload();
        			}
        		}
        	})
        })
        $('#brandfrm').submit(function(e){
        	e.preventDefault()
        	start_load()
        	$.ajax({
        		url:'managebrand.php',
        		method:"POST",
        		data:$(this).serialize(),
        		error:err=>console.log(err),
        		success:function(resp){
        			if(resp == 1){
        				alert("Data successfully saved");
        				location.reload();
        			}
        		}
        	})
        })

        $('.edit_cat').click(function(){
        	start_load()
        	$.ajax({
        		url:'getcat.php?id='+$(this).attr('data-id'),
        		success:function(resp){
        			if(resp){
        				resp = JSON.parse(resp)
        				$('#catfrm [name="id"]').val(resp.cat_id)
        				$('#catfrm [name="name"]').val(resp.cat_title)
        				$('#catmodal .modal-title').html('Edit Category')
        				$('#catmodal').modal('show')
        				end_load()

        			}
        		}
        	})
        })
        $('.edit_brand').click(function(){
        	start_load()
        	$.ajax({
        		url:'getbrand.php?id='+$(this).attr('data-id'),
        		success:function(resp){
        			if(resp){
        				resp = JSON.parse(resp)
        				$('#brandfrm [name="id"]').val(resp.brand_id)
        				$('#brandfrm [name="name"]').val(resp.brand_title)
        				$('#brandmodal .modal-title').html('Edit Brand')
        				$('#brandmodal').modal('show')
        				end_load()

        			}
        		}
        	})
        })

        $('.remove_cat').click(function(){

        	var conf = confirm('Are you sure to delete this data?');
        	if(conf == true){
        	$.ajax({
        		url:'removecat.php?id='+$(this).attr('data-id'),
        		success:function(resp){
        			if(resp == 1){
        				alert('Data succefully deleted.')
        				location.reload()

        			}
        		}
        	})	
        	}

        	
        })
        $('.remove_brand').click(function(){

        	var conf = confirm('Are you sure to delete this data?');
        	if(conf == true){
        	$.ajax({
        		url:'removebrand.php?id='+$(this).attr('data-id'),
        		success:function(resp){
        			if(resp == 1){
        				alert('Data succefully deleted.')
        				location.reload()

        			}
        		}
        	})	
        	}

        	
        })


      </script>