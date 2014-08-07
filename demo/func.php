<?

  require_once('../lib/Tree.php');
  require_once('lib/Item.php');
  
  try {
  
    // Configurate the tree
    $config = array('id' => 'id', 'parent' => 'pid', 'children' => 'sub');

    // Create a new tree-instance
    $tree = Tree::getInstance($config);

    $items = array(
      new Item(99, 3, 'USA'),
      array('id' => 1, 'name' => 'Europe', 'pid' => 0, 'sub' => null),
      array('id' => 2, 'name' => 'Mexico', 'pid' => 3, 'sub' => null),
      array('id' => 3, 'name' => 'North America', 'pid' => 0, 'sub' => null),
      new Item(4, 1, 'France'),
      array('id' => 5, 'name' => 'Germany', 'pid' => 1, 'sub' => null),
    );
    
    // Add many items, passed as one array
    $tree->addMany($items);
    
    // Add many items, passed as single arguments
    $tree->add(new Item(6, 5, 'Berlin'), new Item(12, 5, 'Hamburg'));
    
    // ADd one item
    $tree->add(new Item(7, 99, 'New York'));
    
    // Build the tree
    $result = $tree->build();

  } catch (Exception $e) {
    print $e->getMessage();
  }
  
  /**
   * Simple render method
   */
  function renderBranch($items)
  {
    include('branch.php');
  }