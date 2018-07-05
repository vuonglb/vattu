<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * TomatoCart Open Source Shopping Cart Solution
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License v3 (2007)
 * as published by the Free Software Foundation.
 *
 * @package   TomatoCart
 * @author    TomatoCart Dev Team
 * @copyright Copyright (c) 2009 - 2012, TomatoCart. All rights reserved.
 * @license   http://www.gnu.org/licenses/gpl.html
 * @link    http://tomatocart.com
 * @since   Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Best Orders Model
 *
 * @package   TomatoCart
 * @subpackage  tomatocart
 * @category  template-module-model
 * @author    TomatoCart Dev Team
 * @link    http://tomatocart.com/wiki/
 */
class Best_Orders_Model extends CI_Model
{
    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
// ------------------------------------------------------------------------
    
    /**
     * Get the orders
     *
     * @access public
     * @param $start_date
     * @param $end_date
     * @param $start
     * @param $limit
     * @return mixed
     */
    public function get_orders($start_date, $end_date, $start, $limit)
    {
        $this->query($start_date, $end_date);
        
        $result = $this->db
        ->order_by('value desc')
        ->limit($limit, $start)
        ->get();
        
        if ($result->num_rows() > 0)
        {
            return $result->result_array();
        }
        
        return NULL;
    }
    
// ------------------------------------------------------------------------
    
    /**
     * Get the total number of orders
     *
     * @access public
     * @param $start_date
     * @param $end_date
     * @return int
     */
    public function get_total($start_date, $end_date)
    {
        $this->query($start_date, $end_date);
        
        $result = $this->db->get();
        
        return $result->num_rows();
    }
    
// ------------------------------------------------------------------------
    
    /**
     * Build the query
     *
     * @access private
     * @param $start_date
     * @param $end_date
     * @return void
     */
    private function query($start_date, $end_date)
    {
        $this->db
        ->select('o.orders_id, o.customers_id, o.customers_name, ot.value, o.date_purchased')
        ->from('orders o')
        ->join('orders_total ot', 'o.orders_id = ot.orders_id')
        ->where('ot.class', 'total');
        
        if (!empty($start_date))
        {
            $this->db->where('o.date_purchased >=', $start_date);
        }
        
        if (!empty($end_date))
        {
            $this->db->where('o.date_purchased <=', $end_date);
        }
    }
}

/* End of file best_orders_model.php */
/* Location: ./system/models/best_orders_model.php */