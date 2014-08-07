<?

  /**
   * Tree
   * 
   * Utility to quickly build a rekursive tree with the given elements
   * 
   * @copyright 2014 Squareflower Websolutions
   * @version 0.1.2
   * @author Lukas Rydygel <hallo@squareflower.de>
   * @license Licensed under the MIT license
   */

  class Tree
  {
    
    /**
     * The attribute to identify the item itemself
     * 
     * @var string
     */
    protected $id;
    
    /**
     * Defines which ID will be used as the root
     * 
     * @var mixed
     */
    protected $root;
    
    /**
     * The attribute to identify the items parent
     * 
     * @var string
     */
    protected $parent;
    
    /**
     * The attribute to identify the items children
     * 
     * @var string
     */
    protected $children;
    
    /**
     * The attribute by which the elements in the tree should be sorted
     * 
     * @var string
     */
    protected $sortBy;
    
    /**
     * Holds the items of which the tree will be build
     * 
     * @var array
     */
    protected $items;
    
    /**
     * The classes default attributes
     * 
     * @var array
     */
    protected $def = array(
      'root' => 0,
      'id' => 'id',
      'parent' => 'pid',
      'children' => 'sub',
      'sortBy' => 'id'
    );
    
    /**
     * The constructor
     * coonfiguration will be automatically set
     * 
     * @param array $config
     */
    protected function __construct(array $config = array())
    {      
      $config = array_merge($this->def, $config);
      $this->config($config);
    }
    
    /**
     * Will create a new object
     * 
     * @param type $config
     * @return \Tree
     */
    public function getInstance($config)
    {
      return new self($config);
    }
    
    /**
     * Will configurate the object
     * 
     * @param array $config
     */
    public function config(array $config)
    {
      
      $config = array_intersect_key($config, $this->def);
      
      foreach ($config as $key => $value) {
        $this->$key = $value;
      }
      
    }
    
    /**
     * Will remove all items
     * 
     * @return \Tree
     */
    public function clear()
    {
      $this->items = array();
      return $this;
    }
    
    /**
     * Will add new items
     * comma seperated
     * 
     * @return \Tree
     * @throws \Exception
     */
    public function add()
    {
      
      foreach (func_get_args() as $item) {
        
        if (is_scalar($item)) {
          throw new \Exception("Items must be an array or an object.");
        }
        
        $id = $this->getter($item, $this->id);
        
        $this->items[$id] = $item;
        
      }
      
      return $this;
      
    }
    
    /**
     * Will add many items, passed as one array
     * 
     * @param array $items
     * @return \Tree
     */
    public function addMany(array $items)
    {
      return call_user_func_array(array($this, 'add'), $items);
    }
    
    /**
     * Will remove a set of items
     * accepts the item with the given ID or the ID itself
     * 
     * @return \Tree
     */
    public function remove()
    {
      
      foreach (func_get_args() as $item) {
        
        if (is_scalar($item)) {
          $id = $item;
        } else {
          $id = $this->getter($item, $this->id);
        }
        
        if (array_key_exists($id, $this->items)) {
          unset($this->items[$id]);
        }
        
      }
      
      return $this;
      
    }
    
    /**
     * Will remove many items, passed as one array
     * 
     * @param array $items
     * @return \Tree
     */
    public function removeMany(array $items)
    {
      return call_user_func_array(array($this, 'remove'), $items);
    }
    
    /**
     * Will set an items attribute
     * 
     * @param array|obj $item
     * @param string $attr
     * @param mixed $value
     * @throws \Exception
     */
    protected function setter(&$item, $attr, $value)
    {
      
      if (is_array($item) && array_key_exists($attr, $item)) {
        $item[$attr] = $value;
        return;
      } elseif (is_object($item)) {
        
        $reflection = new ReflectionProperty(get_class($item), $attr);
        
        if (property_exists($item, $attr) && $reflection->isPublic()) {
          $item->$attr = $value;
          return;
        }

        $method = 'set'.ucfirst($attr);
        
        $reflection = new ReflectionMethod(get_class($item), $method);

        if (method_exists($item, $method) && $reflection->isPublic()) {
          $item->$method($value);
          return;
        }
        
      }
      
      throw new \Exception("The attribute '$attr' could not be set.");
      
    }
    
    /**
     * Will get an items attribute
     * 
     * @param array|obj $item
     * @param string $attr
     * @return mixed
     * @throws \Exception
     */
    protected function getter($item, $attr)
    {
      
      if (is_array($item) && array_key_exists($attr, $item)) {
        return $item[$attr];
      } elseif (is_object($item)) {
        
        $reflection = new ReflectionProperty(get_class($item), $attr);
        
        if (property_exists($item, $attr) && $reflection->isPublic()) {
          return $item->$attr;
        }
        
        $method = 'get'.ucfirst($attr);
        
        $reflection = new ReflectionMethod(get_class($item), $method);
        
        if (method_exists($item, $method) && $reflection->isPublic()) {
          return $item->$method();
        }
        
      }
      
      throw new \Exception("The attributes '$attr' does not exist.");
      
    }
    
    /**
     * Will convert and sort the items and build the tree
     * 
     * @return array
     */
    public function build()
    {
      
      $items = array();
      
      foreach ($this->items as $id => $item) {
        
        $sortBy = $this->getter($item, $this->sortBy)."_$id";
        
        $items[$sortBy] = $this->convertItem($item);
        
      }
      
      ksort($items);
      
      return $this->buildRekursive($items, $this->root);
      
    }
    
    /**
     * Converts an item into an array
     * 
     * @param mixed $item
     * @return array
     */
    protected function convertItem($item)
    {
      
      if (is_array($item)) {
        
        $convertedItem = $item;
        
      } elseif (is_object($item)) {
        
        $convertedItem = array();
      
        $reflection = new ReflectionClass(get_class($item));
        
        $properties = $reflection->getProperties();
        
        foreach ($properties as $property) {
          $convertedItem[$property->name] = $this->getter($item, $property->name);
        }
                
      }
      
      if (!property_exists($convertedItem, $this->children)) {
        $convertedItem['children'] = array();
      }
      
      return $convertedItem;
      
    }
    
    /**
     * Will build the tree rekursive
     * 
     * @param array $items
     * @param mixed $root
     * @return array
     */
    protected function buildRekursive(&$items, $root = null)
    {
      
      $tree = array();
      
      foreach ($items as $i => $item) {
        
        $parent = $this->getter($item, $this->parent);
                  
        if (is_null($parent) || $parent === $root) {

          unset($items[$i]);
          
          $id = $this->getter($item, $this->id);
          
          $branch = $this->buildRekursive($items, $id);

          $this->setter($item, $this->children, $branch);

          $tree[] = $item;
          
        }
        
      }
      
      return $tree;
      
    }
    
  }