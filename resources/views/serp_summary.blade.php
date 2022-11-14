<?php
//header('Access-Control-Allow-Headers: *');


use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
require '/Users/sanjanabolla/example-app/vendor/autoload.php';

        $client = Elastic\Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'webproject',
            'body'  => [
                'query' => [
                    "multi_match" => [
                        "query" =>$id, 
                        "type"=> "best_fields",
                        "fields"=>[ "etd_file_id" ] 
                    ]
                    ],
                ]
            ];
        $results = $client->search($params);
        $count = $results['hits']['total']['value'];
        $response = $results['hits']['hits'];
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Web Project</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
  


  <style type="text/css">

    html{
            position: relative;
            min-height: 100%;
    }
  
   /* Add a black background color to the top navigation */
    .topnav {
    background-color: #333;
    overflow: hidden;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
    float: right;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    }

    /* Change the color of links on hover */
    .topnav a:hover {
    background-color: #ddd;
    color: black;
    }

    /* Add a color to the active/current link */
    .topnav a.active {
    background-color: #04AA6D;
    color: white;
    }
    
    body {
    background-color: #D3E2EC;
    }
    
    h3{
      font-size: 30px;
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

    input[type=submit]:hover {
        background-color: #3498DB;
        }

    input[type=submit] {
        width: 70px;
        background-color: #1c87c9;
        color: #ffffff;
        
        }

  </style>
</head>
<body>
  <br />
  <div class="topnav">
      <a href="{{ url('/logout') }}">Logout</a>
      <a href="{{ route('change_password') }}">Update Password</a>
      <a href="{{ route('edit_profile') }}">Update Info</a>
      <a href="{{ route('upload_etd') }}">Upload New ETD</a>
      <a href="{{ url('/profile') }}">My Profile</a>
      <a href="{{ url('/index') }}">Home</a>

      
  </div>
  <br/><br/>


<?php
// if ($count == 0)
// {
//   //echo'<div style="text-align:center;" class="alert alert-danger success-block">';
//   //echo '<p class="head">No Results Found</p>';
//   echo 'No results';
// }

  echo "<br>";
  //echo "<p><b>$count results found for $search</b></p>";

foreach( $response as $r)
    {
        $title= (isset($r['_source']['title'])? $r['_source']['title'] : "");
        $author = (isset($r['_source']['author']) ? $r['_source']['author'] : "");
        $advisor= (isset($r['_source']['advisor']) ? $r['_source']['advisor'] : "");
        $degree= (isset($r['_source']['degree']) ? $r['_source']['degree'] : "");
        $program= (isset($r['_source']['program']) ? $r['_source']['program'] : "");
        $university= (isset($r['_source']['university']) ? $r['_source']['university'] : "");
        $abstract = (isset($r['_source']['abstract']) ? $r['_source']['abstract'] : ""); 
        $wiki_terms = (isset($r['_source']['wiki_terms']) ? $r['_source']['wiki_terms'] : ""); 
        $year= (isset($r['_source']['year'])? $r['_source']['year'] : "");
        $pdf= (isset($r['_source']['pdf'])? $r['_source']['pdf'] : "");


        echo "<p align='center'><b>Title: </b>$title</p>";
        echo "<p style='color:black;'><b>ETD ID:</b> $id</p>";
        echo "<p style='color:black;'><b>Author(s):</b> $author</p>";
        echo "<p style='color:black;'><b>Advisor:</b> $advisor</p>";
        echo "<p style='color:black;'><b>Degree:</b> $degree</p>";
        echo "<p style='color:black;'><b>Program:</b> $program</p>";
        echo "<p style='color:black;'><b>University:</b> $university</p>";
        echo "<p style='color:black;'><b>Year issued:</b> $year</p>";
        echo "<p style='color:black;'><b>Abstract:</b> $abstract</p>";
        echo "<div><p style='color:black;'><b>PDF:</b> $pdf</p></div>";
        echo "URL: <a href='/pdf_view/".$pdf."' target='_blank' rel='noopener noreferrer'>Click Here!</a>";

    }
?>

</body>
</html>