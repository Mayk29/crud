<?php
App::uses('AppController', 'Controller');
class DashboardController extends AppController {
  public $uses = array('Dashboard');
  public $components = array('Global');
  public $layout = null;
  public function index(){
    $colors = array(
      '#C91F37','#4D8FAC','#F7CA18','#26A65B','#875F9A','#DC3023','#5D8CAE','#F3C13A','#26C281','#5D3F6A',
      '#9D2933','#22A7F0','#D9B611','#03A678','#89729E','#CF000F','#19B5FE','#E2B13C','#4DAF7C','#763568',
      '#E68364','#59ABE3','#A17917','#87D37C','#8D608C','#F22613','#F5D76E','#36D7B7','#A87CA0','#CF3A24',
      '#317589','#F4D03F','#16A085','#5B3256','#C3272B','#89C4F4','#FFA400','#2ABB9B','#8E44AD','#8F1D21',
      '#4B77BE','#E08A1E','#049372','#BF55EC','#D24D57','#1F4788','#FFB61E','#006442','#9B59B6','#F9690E'
    );
    
    $this->set(compact('colors'));
   
  }
}
