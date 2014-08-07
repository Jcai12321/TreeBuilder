<?

  class Item
  {
    
    protected $id;
    protected $pid;
    protected $name;
    protected $sub;
    
    public function __construct($id, $pid, $name)
    {
      $this->setId($id);
      $this->setPid($pid);
      $this->setName($name);
    }
    
    public function getId()
    {
      return $this->id;
    }

    public function getPid()
    {
      return $this->pid;
    }

    public function getSub()
    {
      return $this->sub;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function setPid($pid)
    {
      $this->pid = $pid;
    }

    public function setSub($sub)
    {
      $this->sub = $sub;
    }
    
    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }
    
  }