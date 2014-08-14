<?

  require_once('../lib/Tree.php');
  
  $world = array('cca2' => 'WORLD', 'name' => 'World', 'region' => 0);
  
  $continents = array(
    array('cca2' => 'ASIA', 'name' => 'Asia', 'region' => 'World'),
    array('cca2' => 'AFRICA', 'name' => 'Africa', 'region' => 'World'),
    array('cca2' => 'EUROPE', 'name' => 'Europe', 'region' => 'World'),
    array('cca2' => 'AMERICAS', 'name' => 'Americas', 'region' => 'World'),
  );
  
  // https://github.com/mledoze/countries
  $countries = json_decode(file_get_contents('countries.json'), true);
  
  $states = array(
    array('cca2' => 'DE_BW', 'name' => 'Baden-Württemberg', 'region' => 'Germany'),
    array('cca2' => 'DE_BY', 'name' => 'Bayern', 'region' => 'Germany'),
    array('cca2' => 'DE_BE', 'name' => 'Berlin', 'region' => 'Germany'),
    array('cca2' => 'DE_BB', 'name' => 'Brandenburg', 'region' => 'Germany'),
    array('cca2' => 'DE_HB', 'name' => 'Bremen', 'region' => 'Germany'),
    array('cca2' => 'DE_HH', 'name' => 'Hamburg', 'region' => 'Germany'),
    array('cca2' => 'DE_HE', 'name' => 'Hessen', 'region' => 'Germany'),
    array('cca2' => 'DE_MV', 'name' => 'Mecklenburg-Vorpommern', 'region' => 'Germany'),
    array('cca2' => 'DE_NI', 'name' => 'Niedersachsen', 'region' => 'Germany'),
    array('cca2' => 'DE_NW', 'name' => 'Nordrhein-Westfalen', 'region' => 'Germany'),
    array('cca2' => 'DE_RP', 'name' => 'Rheinland-Pfalz', 'region' => 'Germany'),
    array('cca2' => 'DE_SL', 'name' => 'Saarland', 'region' => 'Germany'),
    array('cca2' => 'DE_SN', 'name' => 'Sachsen', 'region' => 'Germany'),
    array('cca2' => 'DE_ST', 'name' => 'Sachsen-Anhalt', 'region' => 'Germany'),
    array('cca2' => 'DE_SH', 'name' => 'Schleswig-Holstein', 'region' => 'Germany'),
    array('cca2' => 'DE_TH', 'name' => 'Thüringen', 'region' => 'Germany')
  );
  
  try {
  
    $config = array('id' => 'name', 'parent' => 'region', 'children' => 'children', 'sortBy' => 'name');

    $tree = Tree::getInstance($config)->add($world)->addMany($continents)->addMany($countries)->addMany($states);

  } catch (Exception $e) {
    print $e->getMessage();
  }
  
?>

<html>
  
  <head>
    
    <title>Tree 0.2</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
    <link rel="stylesheet" type="text/css" href="assets/tree.css" />
    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/tree.js"></script>
    
    <script>
      
      $(function() {
        $('.tree > ul').tree();
      });
      
    </script>
    
  </head>
  
  <body>
    
    <p>Due to the fact that I am lazy, i just added the states of germany.</p>
    
    <div class="tree">
      <? $tree->render('tree.php'); ?>
    </div>
  
  </body>
  
</html>