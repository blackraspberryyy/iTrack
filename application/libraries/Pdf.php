<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
  
class Pdf extends TCPDF {
  function __construct(){
    parent::__construct();
  }

  function Header(){
    $this->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $this->SetAuthor('Systematix');
    $this->SetTitle('iTrack Pdf');  //Default Title
  }

}