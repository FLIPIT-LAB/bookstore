<?php
session_start();
include "dbconnect.php";

if (isset($_GET['Message'])) {
    print '<script type="text/javascript">
               alert("' . $_GET['Message'] . '");
           </script>';
}

if (isset($_GET['response'])) {
    print '<script type="text/javascript">
               alert("' . $_GET['response'] . '");
           </script>';
}

if(isset($_POST['submit']))
{
  if($_POST['submit']=="login")
  { 
        $username=$_POST['login_username'];
        $password=$_POST['login_password'];
        $query = "SELECT * from users where UserName ='$username' AND Password='$password'";
        $result = mysqli_query($con,$query)or die();
        if(mysqli_num_rows($result) > 0)
        {
             $row = mysqli_fetch_assoc($result);
             $_SESSION['user']=$row['UserName'];
             print'
                <script type="text/javascript">alert("successfully logged in!!!");</script>
                  ';
        }
        else
        {    print'
              <script type="text/javascript">alert("Incorrect Username Or Password!!");</script>
                  ';
        }
  }
  else if($_POST['submit']=="register")
  {
        $email=$_POST['register_email'];
        $username=$_POST['register_username'];
        $password=$_POST['register_password'];
        $query="select * from users where UserName = '$username'";
        $result=mysqli_query($con,$query) or die();
        if(mysqli_num_rows($result)>0)
        {   
               print'
               <script type="text/javascript">alert("username is taken");</script>
                    ';

        }
        else
        {
          $query ="INSERT INTO users VALUES ('$email','$username','$password')";
          $result=mysqli_query($con,$query);
          print'
                <script type="text/javascript">
                 alert("Successfully Registered!!!");
                </script>
               ';
        }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Books">
    <meta name="author" content="Shivangi Gupta">
    <title>Online Bookstore</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
    <style>
      .modal-header {background:#D67B22;color:#fff;font-weight:800;}
      .modal-body{font-weight:800;}
      .modal-body ul{list-style:none;}
      .modal .btn {background:#D67B22;color:#fff;}
      .modal a{color:#D67B22;}
      .modal-backdrop {position:inherit !important;}
       #login_button,#register_button{background:none;color:#D67B22!important;}       
       #query_button {position:fixed;right:0px;bottom:0px;padding:10px 80px;
                      background-color:#D67B22;color:#fff;border-color:#f05f40;border-radius:2px;}
  	@media(max-width:767px){
        #query_button {padding: 5px 20px;}
  	}
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav navbar-right">
        <?php
        if(!isset($_SESSION['user']))
          {
            echo'
            <li>
            <li> <a href="index.php" class="btn btn-lg"> Home </a> </li>
                    <li> <a href="index.php" class="btn btn-lg"> Learning Path </a> </li>
            <li> <a href="about.php" class="btn btn-lg"> About </a> </li>
                    <li> <a href="contact.php" class="btn btn-lg"> Contact </a> </li>
                <button style="color:black" type="button" id="login_button" class="btn btn-lg" data-toggle="modal" data-target="#login">Login</button>
                  <div id="login" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Login Form</h4>
                            </div>
                            <div class="modal-body">
                                          <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8">
                                              <div class="form-group">
                                                  <label class="sr-only" for="username">Username</label>
                                                  <input type="text" name="login_username" class="form-control" placeholder="Username" required>
                                              </div>
                                              <div class="form-group">
                                                  <label class="sr-only" for="password">Password</label>
                                                  <input type="password" name="login_password" class="form-control"  placeholder="Password" required>
                                              </div>
                                              <div class="form-group">
                                                  <button type="submit" name="submit" value="login" class="btn btn-block">
                                                      Sign in
                                                  </button>
                                              </div>
                                          </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                  </div>
            </li>
            <li>
              <button type="button" id="register_button" class="btn btn-lg" data-toggle="modal" data-target="#register">Sign Up</button>
                <div id="register" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title text-center">Member Registration Form</h4>
                          </div>
                          <div class="modal-body">
                                        <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8">
                                            <div class="form-group">
                                            <div class="form-group">
                                                  <label class="sr-only" for="email">Email</label>
                                                  <input type="text" name="register_email" class="form-control" placeholder="Email" required>
                                              </div>
                                                <label class="sr-only" for="username">Username</label>
                                                <input type="text" name="register_username" class="form-control" placeholder="Username" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="password">Password</label>
                                                <input type="password" name="register_password" class="form-control"  placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="submit" value="register" class="btn btn-block">
                                                    Sign Up
                                                </button>
                                            </div>
                                        </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
                </div>
            </li>';
          } 
        else
          {   echo' 
            <li> <a href="index.php" class="btn btn-lg"> Home </a> </li>
                    <li> <a href="cart.php" class="btn btn-lg"> My Subscriptions </a> </li>
            <li> <a href="cart.php" class="btn btn-lg"> Cart </a> </li>
                    <li> <a href="about.php" class="btn btn-lg"> About </a> </li>
                    <li> <a href="contact.php" class="btn btn-lg"> Contact </a> </li>
                    <li> <a href="destroy.php" class="btn btn-lg"> LogOut </a> </li>
                    <li> <a style="color:black" href="profile.php" class="btn btn-lg"> Hello ' .$_SESSION['user']. '!</a></li>
                    ';
               
          }
?>

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  <div id="top" >
      <div id="searchbox" class="container-fluid" style="width:112%;margin-left:-6%;margin-right:-6%;">
          <div>
              <form role="search" method="POST" action="Result.php">
                  <input type="text" class="form-control" name="keyword" style="width:80%;margin:20px 10% 20px 10%;" placeholder="Search for a Book , Author Or Category">
              </form>
          </div>
      </div>

      <div class="container-fluid" id="header">
          <div class="row">
              <div class="col-md-3 col-lg-3" id="category">
              <!-- <h4 class="text-center"><b>Categories</b></h4> -->
                  <div style="background:#D67B22;color:#fff;font-weight:800;border:none;padding:15px; margin-top:12px"> FLIPS ELEARNING COURSES </div>
                  <ul>
                     <a href="Product.php?value=front%20end"> <li>  FRONT END </li></a>
                      <a href="Product.php?value=back%20end"><li> BACKEND </li></a>
                      <a href="Product.php?value=bundles"><li>  BUNDLES  </li></a>
                      <a href="Product.php?value=computer%20essentials"> <li> COMPUTER SCIENCE ESSENTIALS </li></a> 
                  </ul>
              </div>
              <div class="col-md-6 col-lg-6">
                  <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                      <!-- Indicators -->
                      <ol class="carousel-indicators">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                          <li data-target="#myCarousel" data-slide-to="3"></li>
                          <li data-target="#myCarousel" data-slide-to="4"></li>
                          <li data-target="#myCarousel" data-slide-to="5"></li>
                      </ol>
                      
                        <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                          <div class="item active">
                            <img class="img-responsive" src="img/carousel/net.jpg">
                          </div>

                          <div class="item">
                            <img class="img-responsive "src="img/carousel/datasctructure.jpg">
                          </div>

                          <div class="item">
                            <img class="img-responsive" src="img/carousel/entity.jpg">
                          </div>

                          <div class="item">
                            <img class="img-responsive"src="img/carousel/sql.jpg">
                          </div>

                          <div class="item">
                            <img class="img-responsive" src="img/carousel/xamarin.jpg">
                          </div>

                          <div class="item">
                            <img class="img-responsive" src="img/carousel/asp.png">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-3 col-lg-3" id="offer">
                <!-- <h4 class="text-center"><b>Offers</b></h4> -->
                  <a href="description.php?ID=JV-1&category=back end"> <img class="img-responsive center-block" src="img/offers/java.jpg"></a>
                  <a href="description.php?ID=OOPIJ-6&category=front end"> <img class="img-responsive center-block" src="img/offers/js.png"></a>
              </div>
          </div>
      </div>
  </div>

  <div class="container-fluid text-center" id="new">
      <div class="row">
          <div class="col-sm-6 col-md-4 col-lg-4">
           <a href="description.php?ID=NEW-1&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="book block-center img-responsive" src="img/all2.jpg">
                  <hr>
                  ALL ACCESS SUBSCRIPTION <br>
                   $ 500  &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 175 </span>
                  <span class="label label-warning">35%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TURIA-1&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/redux.jpg">
                  <hr>
                  THE ULTIMATE REDUX IN ANGULAR<br>
                  Rs 68 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 120 </span>
                  <span class="label label-warning">43%</span>
              </div>
            </a>
          </div>
		  <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TURC-2&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/react.jpg">
                  <hr>
                  MASTERING REACT <br>
                  $ 68 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 120 </span>
                  <span class="label label-warning">43%</span>
              </div>
            </a>
          </div>
		  <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=NODE-1&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/node.png">
                  <hr>
                  COMPLETE NODE.JS COURSE <br>
                  $ 68 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 120 </span>
                  <span class="label label-warning">43%</span>
              </div>
            </a>
          </div>
		  <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CMSM-4&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/sql.jpg">
                  <hr>
                  COMPELTE SQL MASTERY <br>
                  $ 68 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 120 </span>
                  <span class="label label-warning">43%</span>
              </div>
            </a>
          </div>
		  <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=XFBNAW-5&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/xamarin.jpg">
                  <hr>
                  XAMARINE FORMS : NATIVE APPS WITH C#  <br>
                  $ 68 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 120 </span>
                  <span class="label label-warning">43%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=UDS-6&category=new">
              <div class="book-block">
                  <div class="tag">New</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/tudps.jpg">
                  <hr>
                   ULTIMATE DATA STRUCTURE COMPLETE COURSE <br>
                  $ 400 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 595 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=UT-7&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/unittesting.png ">
                  <hr>
                  UNIT TESTING <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TCANMC-8&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/mvc.jpg">
                  <hr>
                  THE COMPLETE ASP.NET MVC 5 COURSE  <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CCAR-9&category=new">
              <div class="book-block">
                  <div class="tag">UPDATED</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/cleancoding.png">
                  <hr>
                  CLEAN CODING AND REFACTORING <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TCNJC-3&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/node.png">
                  <hr>
                  THE COMPLETE NODE.JS COURSE <br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=EFD-11&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/entity.jpg">
                  <hr>
                  ENTITY FRAMEWORK DEPTH <br>
                  $ 59 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TCPC-12&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/V1.jpg">
                  <hr>
                  THE COMPLETE PYTHON COURSE <br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=VSE-1&category=new">
              <div class="book-block">
                  <div class="tag">MOST POPULAR</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/csharp.jpg">
                  <hr>
                  VISUAL STUDIO ESSENTIALS <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=BRAAC-2&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/asp.png">
                  <hr>
                  Build a Real-world App with ASP.NET Core 1.0+ <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=UJPF-3&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/java.jpg">
                  <hr>
                  ULTIMATE JAVA PART 1 (FUNDAMENTALS)<br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=UJPOOP-4&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/java2.jpg">
                  <hr>
                  ULTIMATE JAVA PART 2 : (OBJECT ORIENTED)<br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=UJPA-5&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/java3.jpg">
                  <hr>
                 ULTIMATE JAVA PART 3 : (ADVANCED)<br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=OOP-1&category=new">
              <div class="book-block">
                  <div class="tag">NEW</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/books/OOP-1.JPG">
                  <hr>
                  OBJECT ORIENTED PROGRAMMING IN JAVASCRIPT<br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=ABTP-7&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/angular.jpg">
                  <hr>
                 ANGULAR 4 : BEGINNER TO PRO <br>
                  $ 89 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CDDYCS-8&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/csharp.jpg">
                  <hr>
                  C# DEVELOPERS : DOUBLE YOUR CODING SPEED<br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CCCA-9&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/csharp1.jpg">
                  <hr>
                  COMPLETE C# COURSE (PART 1) <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CCCB-10&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/csharp2.jpg">
                  <hr>
                  COMPLETE C# COURSE (PART 2) <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=CCCC-11&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/csharp3.jpg">
                  <hr>
                  COMPLETE C# COURSE (PART 3) <br>
                  $ 29 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TUDSCA-12&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/datastructure2.jpg">
                  <hr>
                  THE ULTIMATE DATA STRUCTURE COURSE (PART 1) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TUDSCB-13&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/datasctructure.jpg">
                  <hr>
                  THE ULTIMATE DATA STRUCTURE COURSE (PART 2) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TUDSCC-2&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/datastructure3.jpg">
                  <hr>
                  THE ULTIMATE DATA STRUCTURE COURSE (PART 3) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=OOPIJ-6&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/js.png">
                  <hr>
                  THE ULTIMATE DATA STRUCTURE COURSE (PART 3) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TUDPA-4&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/tudps.jpg">
                  <hr>
                  THE ULTIMATE DESIGN PATTERN (PART 1) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-md-3 col-lg-4">
           <a href="description.php?ID=TUDPB-5&category=new">
              <div class="book-block">
                  <div class="tag">TRENDING</div>
                  <div class="tag-side"><img src="img/tag.png"></div>
                  <img class="block-center img-responsive" src="img/tudps.jpg">
                  <hr>
                  THE ULTIMATE DESIGN PATTERN (PART 2) <br>
                  $ 49 &nbsp
                  <span style="text-decoration:line-through;color:#828282;"> 435 </span>
                  <span class="label label-warning">33%</span>
              </div>
            </a>
          </div>
      </div>
  </div>


  <footer style="margin-left:-6%;margin-right:-6%;">
      <div class="container-fluid">
          <div class="row">
              <div class="col-sm-1 col-md-1 col-lg-1">
              </div>
              <div class="col-sm-7 col-md-5 col-lg-5">
                  <div class="row text-center">
                      <h2>Let's Get In Touch!</h2>
                      <hr class="primary">
                      <p>Want any info? Give us a call or send us an email and we will get back to you as soon as possible!</p>
                  </div>
                  <div class="row">
                      <div class="col-md-6 text-center">
                          <span class="glyphicon glyphicon-earphone"></span>
                          <p>123-456-6789</p>
                      </div>
                      <div class="col-md-6 text-center">
                          <span class="glyphicon glyphicon-envelope"></span>
                          <p>elearning@gmail.com</p>
                      </div>
                  </div>
              </div>
              <div class="hidden-sm-down col-md-2 col-lg-2">
              </div>
              <div class="col-sm-4 col-md-3 col-lg-3 text-center">
                  <h2 style="color:#D67B22;">Follow Us At</h2>
                  <div>
                      <a href="https://twitter.com/strandbookstore">
                      <img title="Twitter" alt="Twitter" src="img/social/twitter.png" width="35" height="35" />
                      </a>
                      <a href="https://www.linkedin.com/company/strand-book-store">
                      <img title="LinkedIn" alt="LinkedIn" src="img/social/linkedin.png" width="35" height="35" />
                      </a>
                      <a href="https://www.facebook.com/strandbookstore/">
                      <img title="Facebook" alt="Facebook" src="img/social/facebook.png" width="35" height="35" />
                      </a>
                      <a href="https://plus.google.com/111917722383378485041">
                      <img title="google+" alt="google+" src="img/social/google.jpg" width="35" height="35" />
                      </a>
                      <a href="https://www.pinterest.com/strandbookstore/">
                      <img title="Pinterest" alt="Pinterest" src="img/social/pinterest.jpg" width="35" height="35" />
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </footer>

<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" id="query_button" class="btn btn-lg" data-toggle="modal" data-target="#query">Have a question?</button>
  <!-- Modal -->
  <div class="modal fade" id="query" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Ask your question or put your suggestion here</h4>
          </div>
          <div class="modal-body">           
                    <form method="post" action="query.php" class="form" role="form">
                        <div class="form-group">
                             <label class="sr-only" for="name">Name</label>
                             <input type="text" class="form-control"  placeholder="Your Name" name="sender" required>
                        </div>
                        <div class="form-group">
                             <label class="sr-only" for="email">Email</label>
                             <input type="email" class="form-control" placeholder="abc@gmail.com" name="senderEmail" required>
                        </div>
                        <div class="form-group">
                             <label class="sr-only" for="query">Message</label>
                             <textarea class="form-control" rows="5" cols="30" name="message" placeholder="Your Question here" required></textarea>
                        </div>
                        <div class="form-group">
                              <button type="submit" name="submit" value="query" class="btn btn-block">
                                                              Submit
                               </button>
                        </div>
                    </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>  
  </div>
</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>	