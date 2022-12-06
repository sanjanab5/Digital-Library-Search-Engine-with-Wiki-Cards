<?php

use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Str;

require '/Users/sanjanabolla/example-app/vendor/autoload.php';

        $client = Elastic\Elasticsearch\ClientBuilder::create()->build();
        
        if(isset($_GET['search']))
        {
          $srch = $_GET['search'];
        }

       $srch = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($srch))))));

        if($srch == '' || Str::length($srch) == 0) {
          return Redirect::back();
        }
        $params = [
            'index' => 'webproject2',
            'explain' => true,
            'from' =>0,
            'size' => 800,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $srch,
                        'fuzziness' => 'AUTO',
                        'fields' => ['title','$year','abstract','university','author','degree','program','advisor'],
                    ],
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
  <title>Digital Library</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
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
<div class="topnav">
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/register') }}">Register</a>
      <a href="{{ url('/') }}">Home</a>
  </div>
  <br/><br/>
  <h3 align="center">Digital Library Search Engine</h3><br />
  <br/><br/>
  <form action = "{{ route('search') }}" method = "GET">
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
  echo "<p align='center'><b>No results found</b></p>";
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
        $wiki_terms= (isset($r['_source']['wiki_terms'])? (!empty($srch)?highlightWords($r['_source']['wiki_terms'],$srch):$r['_source']['wiki_terms']): "");
        $year= !empty($srch)?highlightWords($r['_source']['year'],$srch):$r['_source']['year'];
        $etd_file_id= !empty($srch)?highlightWords($r['_source']['etd_file_id'],$srch):$r['_source']['etd_file_id'];
        $pdf= !empty($srch)?highlightWords($r['_source']['pdf'],$srch):$r['_source']['pdf'];


        echo "<br>";
        
        $link_address = "/dissertation_view";
        echo "<p><b><a href='/dissertation_view/".$etd_file_id."'>$title</a></b></p>";
        echo "<p style='color:black;'><b>Author(s):</b> $author</p>";
        echo "<p style='color:black;'><b>University:</b> $university</p>";
        echo "<p style='color:black;'><b>Year:</b> $year</p>";

        $brief_abstract = $abstract;    
        $maxPos = 400;           
        if (strlen($brief_abstract) > $maxPos)
        {
            $lastPos = ($maxPos - 3) - strlen($brief_abstract);
            $brief_abstract = substr($brief_abstract, 0, strrpos($brief_abstract, ' ', $lastPos)) . '...';
        }
        echo "<div><p style='color:black;'><b>Abstract:</b> ".substr($brief_abstract, 2, -2)."</p></div>";
  
    }

}

?>
</ul>
<ul class="pagination"></ul>

</div>
@include('footer')
</body>
</html>
