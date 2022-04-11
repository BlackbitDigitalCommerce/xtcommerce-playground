<?php


class xt_ga_item {

  protected $index = 1;
  protected $item_list_id = '';
  protected $item_list_name = '';



  public function set_name($name) {
    $this->item_name = $name;
  }

  public function set_id($id) {
    $this->item_id = $id;
  }

  public function set_price($price) {
    $this->price = number_format($price, 2, '.', '');
  }

  public function set_brand($brand) {
    $this->item_brand = $brand;
  }

  public function set_category($category) {
    $this->item_category = $category;
  }


  public function set_quantity($quantity) {
    $this->quantity = round($quantity,0);
  }

  public function set_index($index) {
    $this->index = $index;
  }

  public function set_variant($variant) {
    $this->item_variant = $variant;
  }

  public function getItemDataLayerArray() {

    $item = [];
    $item=array('name'=>$this->item_name,
      'id'=>$this->item_id,
      'brand'=>$this->item_brand,
      'category'=>$this->item_category,
      'variant'=>$this->item_variant ? $this->item_variant : '',
      'list_name'=>'',
      'list_position'=>'',
      'quantity'=>$this->quantity,
      'price'=>$this->price);

    return $item;

  }



}
