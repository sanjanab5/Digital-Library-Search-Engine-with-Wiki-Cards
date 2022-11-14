<?php

use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
require '/Users/sanjanabolla/example-app/vendor/autoload.php';

        $client = Elastic\Elasticsearch\ClientBuilder::create()->build();
        
        if(isset($_GET['search']))
        {
          $srch = $_GET['search'];
        }

       $srch = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($srch))))));

        //$srch = strip_tags(htmlspecialchars_decode($srch));
        if($srch == '' || Str::length($srch) == 0) {
            return redirect()->route('home');
        }
        $params = [
            'index' => 'webproject',
            'explain' => true,
            'from' =>0,
            'size' => 500,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $srch,
                        'fields' => ['title','$year','abstract','wiki_terms','university','author','degree','program','advisor','$etd_file_id','pdf'],
                    ],
                    ],
                    'highlight' => [
                        "pre_tags" => ["<mark>"],
                        "post_tags" => ["</mark>"],
                        "fields" => [
                            "title" => new \stdClass(),
                            "abstract" => new \stdClass(),
                            "wiki_terms" => new \stdClass(),
                        ],
                        'require_field_match' => false
                    ],
                ]
            ];
        $results = $client->search($params);
        $count = $results['hits']['total']['value'];
        $response = $results['hits']['hits'];

        function highlightWords($text,$word) {
            $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
            return $text;
        }
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

<!-- Pagination -->
  <script type="text/javascript">
  $(document).ready(function(){
    var options={
      valueNames:['title','$year','abstract','university','author','$etd_file_id'],
      page:75,
      pagination: true
    }
    var listObj = new List('listId',options);
  });
 </script>


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
   <br/>
  <br/><br/>
  <form action = "{{ route('lsearch') }}" method = "GET">
        @csrf
      <input type="text" name="search" class="search" value="<?php echo"$srch"?>">
      <input type="submit" name="submit" class="submit" value="Search">
  </form>
<br/>

<div id="listId">
		<ul class="list">


<?php

if ($count == 0)
{
  //echo'<div style="text-align:center;" class="alert alert-danger success-block">';
  //echo '<p class="head">No Results Found</p>';
  echo 'No results';
}

else
{
  echo "<br>";
  echo "<p><b>$count results found for $srch</b></p>";

  foreach( $response as $r)
    {
        $title= !empty($srch)?highlightWords($r['_source']['title'],$srch):$r['_source']['title'];
        $author= !empty($srch)?highlightWords($r['_source']['author'],$srch):$r['_source']['author'];
        $advisor= (isset($r['_source']['advisor']) ? highlightWords($r['_source']['advisor'],$srch) : "");
        $degree= !empty($srch)?highlightWords($r['_source']['degree'],$srch):$r['_source']['degree'];
        $program= !empty($srch)?highlightWords($r['_source']['program'],$srch):$r['_source']['program'];
        $university= !empty($srch)?highlightWords($r['_source']['university'],$srch):$r['_source']['university'];
        $abstract = (isset($r['_source']['abstract']) ? highlightWords($r['_source']['abstract'],$srch) : ""); 
        $wiki_terms= !empty($srch)?highlightWords($r['_source']['wiki_terms'],$srch):$r['_source']['wiki_terms'];
        $year= !empty($srch)?highlightWords($r['_source']['year'],$srch):$r['_source']['year'];
        $etd_file_id= !empty($srch)?highlightWords($r['_source']['etd_file_id'],$srch):$r['_source']['etd_file_id'];
        $pdf= !empty($srch)?highlightWords($r['_source']['pdf'],$srch):$r['_source']['pdf'];

        // //$title= (isset($r['_source']['title'])? $r['_source']['title'] : "");
        // //$author = (isset($r['_source']['author']) ? $r['_source']['author'] : "");
        // $advisor= (isset($r['_source']['advisor']) ? highlightWords($r['_source']['advisor'],$srch) : "");
        // //$degree= (isset($r['_source']['degree']) ? $r['_source']['degree'] : "");
        // //$program= (isset($r['_source']['program']) ? $r['_source']['program'] : "");
        // //$university= (isset($r['_source']['university']) ? $r['_source']['university'] : "");
        // $abstract = (isset($r['_source']['abstract']) ? highlightWords($r['_source']['abstract'],$srch) : ""); 
        // //$wiki_terms = (isset($r['_source']['wiki_terms']) ? $r['_source']['wiki_terms'] : ""); 
        // //$year= (isset($r['_source']['year'])? $r['_source']['year'] : "");
        // //$etd_file_id = (isset($r['_source']['etd_file_id'])? $r['_source']['etd_file_id'] : "");
        // //$pdf = (isset($r['_source']['pdf']) ? $r['_source']['pdf'] : ""); 




        // function highlightWords($title, $srch){
        // $title = preg_replace('#'. preg_quote($srch) .'#i', '<span class="hlw">\\0</span>', $title);
        // return $title;
        // }

        echo "<br>";
        
        $link_address = "/dissertation_view";
        echo "<p><b><a href='/dissertation_view/".$etd_file_id."'>$title</a></b></p>";
        echo "<p style='color:black;'><b>Author(s):</b> $author</p>";
        echo "<p style='color:black;'><b>University:</b> $university</p>";
        echo "<p style='color:black;'><b>Year:</b> $year</p>";
        echo "<p style='color:black;'><b>file_id:</b> $etd_file_id</p>";

        $brief_abstract = $abstract;    
        $maxPos = 400;           
        if (strlen($brief_abstract) > $maxPos)
        {
            $lastPos = ($maxPos - 3) - strlen($brief_abstract);
            $brief_abstract = substr($brief_abstract, 0, strrpos($brief_abstract, ' ', $lastPos)) . '...';
        }
        echo "<div><p style='color:black;'><b>Abstract:</b> $brief_abstract</p></div>";
        echo "<div><p style='color:black;'><b>PDF:</b> $pdf</p></div>";


  
    }

}

?>
</ul>

<ul class="pagination"></ul>

</div>

</body>

</html>
