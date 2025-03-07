
    <?php
include("../db.php");
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete')
{
$user_id=$_GET['user_id'];

/*this is delet quer*/
mysqli_query($con,"delete from user_info where user_id='$user_id'")or die("query is incorrect...");
}

include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
         <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">User List</h4>
              </div>
              <div class="card-body">
                <div class="col-md-12">
                  <div class="row">
                    <a href="index.php?page=adduser" class="btn btn-primary btn-sm float-right ">Add New</a>
                  </div>
                </div>
                <div class="table-responsive ps">
                  <table class="table table-striped table-bordered" id="">
                    <thead class="">
                      <tr>
                        <th>User Name</th>
                        <th>User Email</th>
	                       <th>Action</th>
                    </tr></thead>
                    <tbody>
                      <?php 
                        $result=mysqli_query($con,"SELECT * from user_info");

                        while($row=
                        mysqli_fetch_array($result))
                        {
                        ?>
                        <tr>
                          <td><?php echo ucwords($row['first_name'].' '.$row['last_name']) ?></td>
                          <td><?php echo $row['email'] ?></td>
                          <td class="text-center">
                            <a href="index.php?page=edituser&user_id=<?php echo $row['user_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                             <a href="javascript:void(0)" class="btn btn-sm btn-danger">Delete</a>
                          </td>
                        </tr>
                        <?php
                        }
                        mysqli_close($con);
                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <?php
include "footer.php";
?>