<?php
include './api/include/API.php';

$api = new API();
echo "<div style='display: none'>";
$re = $api->CallAPI("GET", "http://104.198.75.154/Corazon/api/get");
echo "</div>";
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Corazon</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Corazon</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="api.html">API</a></li>
            <li><a href="test.php">Test</a></li>
            </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Datos:</h1>
          <table class="table table-hover">

			<thead>
			    <tr>
			        <th>ID</th>
			        <th>Pulsaciones</th>
			        <th>Fecha</th>
			    </tr>
			</thead>
			<tfoot>
			    <tr>
			        <th>ID</th>
			        <th>Pulsaciones</th>
			        <th>Fecha</th>
			    </tr>
			</tfoot>
			<tbody>
			<?php
		$data =  json_decode($re);

		    if (count($data->assignments)) {
		        // Open the table

		        // Cycle through the array
		        foreach ($data->assignments as $idx => $stand) {
		            // Output a row
		            echo "<tr>";
		            echo "<td>$stand->id</td>";
		            echo "<td>$stand->pulsaciones</td>";
		            echo "<td>$stand->fecha</td>";
		            echo "</tr>";
		        }

		        // Close the table
		    }
			?>
			</tbody>
          </table>
      </div>
    </div>

    <div class="container">

      <hr>

      <footer>
        <p>&copy; RICHINATION INC. 2016</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
