<?php
  /**
   * Donate Class
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Donate
  {
      
	  const mTable = "plug_donate";


      /**
       * Donate::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  $this->getconfig();
      }

	  /**
	   * Donate::getconfig()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  
		  $row = INI::read(PLUGPATH . 'donate/config.ini');
		  
		  $this->atarget = $row->don_config->atarget;
		  $this->paypal = $row->don_config->paypal;
		  $this->thankyou = $row->don_config->thankyou;
	
		  return ($row) ? $row : 0;
	  }


	  /**
	   * Donate::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
	
		  Filter::checkPost('atarget', Lang::$word->_PLG_DP_TARGET);
		  Filter::checkPost('paypal', Lang::$word->_PLG_DP_PAYPAL);
	
		  if (empty(Filter::$msgs)) {
			  $data = array('don_config' => array(
					  'atarget' => floatval($_POST['atarget']),
					  'paypal' => sanitize($_POST['paypal']),
					  'thankyou' => sanitize($_POST['page_id']),
					  ));
	
			  if (INI::write(PLUGPATH . 'donate/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_DP_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_DP_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/donate/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  
	  /**
	   * Donate::getDonations()
	   * 
	   * @return
	   */
	  public function getDonations()
	  {

		  $counter = countEntries(self::mTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
		  
		  $sql = "SELECT * FROM " . self::mTable . $pager->limit;
		  $row = Registry::get("Database")->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  } 

	  /**
	   * Donate::countDonations()
	   * 
	   * @return
	   */
	  public function countDonations()
	  {
		  
		  $sql = "SELECT SUM(amount) as total FROM " . self::mTable;
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;
	  }

	  /**
	   * Donate::donationPercentage()
	   * 
	   * @return
	   */
	  public function donationPercentage($paid, $total)
	  {
		  return ($paid > 0) ? number_format(($paid * 100) / $total) : 0;

	  }
	  
  }
?>