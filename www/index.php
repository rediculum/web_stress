<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>Web Stress</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<h2>
<?php
echo "Host: " . gethostname()
?>
</h2>
Stress parameters:
<div class="row">
<div class="col-1">
<form>
Delay:
<select name=delay>
  <option value=5>5</option>
  <option value=10>10</option>
  <option value=15>15</option>
</select>sec
</div>
<div class="col-1">
CPUs:
<select name=cpu>
  <option value=1>1</option>
  <option value=4>4</option>
  <option value=8>8</option>
</select>
</div>
<div class="col-1">
Duration:
<select name=timeout>
  <option value=10>10</option>
  <option value=30>30</option>
  <option value=60>60</option>
</select>sec
</div>
<div class="col">
<input type=submit name=submit>
</div>
</div>
</form>

<?php
function stress(int $delay, int $cpu, int $timeout) {
  exec("sleep $delay; nohup stress -c $cpu -t $timeout");

}

if (isset($_REQUEST['submit'])) {
  echo "Stressed your server after ";
  echo "$_REQUEST[delay]";
  echo "s with ";
  echo "$_REQUEST[cpu]";
  echo "CPUs until ";
  echo "$_REQUEST[timeout]";
  echo "s passed.";

  stress($_REQUEST[delay],$_REQUEST[cpu],$_REQUEST[timeout]);
}
?>

</body>
</html>
