<?php

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;
use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;

require '/Users/sanjanabolla/example-app/vendor/autoload.php';

$client = Elastic\Elasticsearch\ClientBuilder::create()->build();


if ( isset( $_FILES['pdf'] ) ) 
{
    $pdfname = $_FILES['pdf']['name'];
	if ($_FILES['pdf']['type'] == "application/pdf") 
    {
		$source_file = $_FILES['pdf']['tmp_name'];
		$dest_file = "/Applications/XAMPP/xamppfiles/htdocs/PDF/".$_FILES['pdf']['name'];

		if (file_exists($dest_file)) {
			print "The file name already exists!!";
		}
		else {
			move_uploaded_file( $source_file, $dest_file )
			or die ("Error!!");
			if($_FILES['pdf']['error'] == 0) 
            {
                echo "<br><br><div class='alert alert-success'>
                Pdf file uploaded successfully!<br/>
                <b><u>Details : </u></b><br/>
                File Name : ".$_FILES['pdf']['name']."<br.>"."<br/>
                File Size : ".$_FILES['pdf']['size']." bytes"."<br/>
                File location : /Applications/XAMPP/xamppfiles/htdocs/PDF/".$_FILES['pdf']['name']."<br/>
                </div>";
            }
	    }
	}
    else 
    {
	    if ( $_FILES['pdf']['type'] != "pdf") 
        {
            echo "<br><br><div class='alert alert-danger'>
            Error occured while uploading file : ".$_FILES['pdf']['name']."<br/>
            Invalid  file extension, should be pdf !!"."<br/>
            Error Code : ".$_FILES['pdf']['error']."<br/>
            </div>";
	    }
    }
}

if (!empty($_POST)) {
	if(isset($_POST['title'], $_POST['author'], $_POST['year'], $_POST['advisor'], $_POST['program'], $_POST['degree'], $_POST['university'], $_POST['abstract'])) {

		$title = $_POST['title'];
		$author = $_POST['author'];
        $year = $_POST['year'];
        $advisor = $_POST['advisor'];
        $program = $_POST['program'];
        $degree = $_POST['degree'];
        $university = $_POST['university'];
        $abstract = $_POST['abstract'];

        $params = [
            'index' => 'webproject',
            'type' => '_doc',
            'body'  => [
                        'title' => $title,
                        'author' => $author,
                        'year' => $year,
                        'advisor' => $advisor,
                        'program' => $program,
                        'degree' => $degree,
                        'university' => $university,
                        'abstract' => $abstract,
                        'etd_file_id' => rand(500,600),
                        'pdf' => $pdfname
                        ],  
        ];

        $response = $client->index($params);

	}
}
?>


<!DOCTYPE html>
<html>
 <head>
  <title>Upload ETD</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

  <style type="text/css">
  
    .topnav {
    background-color: #333;
    overflow: hidden;
    }

    .topnav a {
    float: right;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    }

    .topnav a:hover {
     background-color: #ddd;
     color: black;
    }

    .topnav a.active {
     background-color: #04AA6D;
    color: white;
    }

    body {
      background-color: #D3E2EC;
      
    }

    form {
    width: 400px;
    margin: auto;
    }

    input {
    padding: 4px 10px;
    border: 0;
    font-size: 16px;
    }

    .search {
    width: 75%;
    }

    
    h3{
      font-size: 30px;
    }

    input[type=submit]:hover {
        background-color: #3498DB;
        }

    input[type=submit] {
        width: 70px;
        background-color: #1c87c9;
        color: #ffffff;
        
        }

      .alert{
        color: black;
        border-radius: 5px;
        background-color: #89C873;
        padding: 20px;
        width:500px;
        margin:0 auto;
        border:1px solid #ccc;
      }
    
  </style>
 </head>
 <body>
 @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger" role = "alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        </div>
    @endif
  <br />
  <div class="topnav">
      <a href="{{ url('/logout') }}">Logout</a>
      <a href="{{ route('change_password') }}">Update Password</a>
      <a href="{{ route('edit_profile') }}">Update Info</a>
      <a href="{{ url('/profile') }}">My Profile</a>
      <a href="{{ url('/index') }}">Home</a>
  </div>
    
    <h3 align="center">Upload ETD</h3><br />
  
  <div>
   
  <form method="POST" action="{{ route('uploadetd_success') }}" enctype="multipart/form-data">
       
       {{ csrf_field()  }}
       
       <div class="form-group">
           <label>Title:</label>
           <input type="text" name="title" class="form-control" />
       </div>
       <div class="form-group">
           <label>Author:</label>
           <input type="text" name="author" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>Year published:</label>
           <input type="year" name="year" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>Advisor:</label>
           <input type="text" name="advisor" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>Program:</label>
           <input type="text" name="program" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>Degree:</label>
           <input type="text" name="degree" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>University:</label>
           <input type="text" name="university" class="form-control" />
       </div><br/>
       <div class="form-group">
           <label>Abstract:</label><br>
           <!-- <input type="text" name="abstract" ows="5" cols="52" class="form-control" /> -->
           <textarea name="abstract" rows="5" cols="52"></textarea>
       </div><br/>
       <div class="form-group">
           <label>Upload PDF:</label>
           <input type="file" name="pdf" class="form-control" />
       </div><br/>
       <div class="form-group">
           <input type="submit" name="upload" class="btn btn-primary" value="Upload" />
           </div>
       <br/><br/><br/>

  </form>
    <br/><br/>
    
   <br/>
  </div>
 </body>
</html>
