<? require_once('func.php'); ?>

<html>
  
  <head>
    
    <title>Tree</title>

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
  
    <h4>Here is the html-tree:</h4>
    
    <div class="tree">
      <? renderBranch($result); ?>
    </div>
    
    <h4>Here is the php tree-object:</h4>
    
    <pre>
      <? print_r($tree); ?>
    </pre>
  
  </body>
  
</html>