<?php
/**
* Template class
*/
class Template {

  private $templateData;
  
  public function __construct () {
    $this->templateData = new ArrayObject();
  }
  
  public function add ($key, $value) {
    $this->templateData->offsetSet($key,$value);
  }
    
  public function show ($template, $base = 'BASETEMPLATE') {
    // Make keys into variables that can be used in the template
    $iterator = $this->templateData->getIterator();
    while ($iterator->valid()) {
      $key = $iterator->key();
      $value = $iterator->current();
      $iterator->next();
      // the magic
      $$key = $value;
    }
    // Show the called template
    include ROOT . 'templates' . DIRECTORY_SEPARATOR . $base . '.php';
  } 
}
?>