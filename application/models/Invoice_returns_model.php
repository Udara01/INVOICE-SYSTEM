<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_returns_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getLastReturnInvoiceNo() {
        $this->db->select('return_invoice_no');
        $this->db->from('invoice_returns');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->return_invoice_no;
        } else {
            return null;
        }
    }

    public function create_return_invoice($data) {
        $this->db->insert('invoice_returns', $data);
        return $this->db->insert_id(); 
    }

    //fetch return invoice by ID
public function get_invoice_by_id($return_invoice_id) {
    $this->db->select('ir.*, ci.invoiceNo, ci.created_at, c.name as customer_name');
    $this->db->from('invoice_returns ir');
    $this->db->join('customer_invoices ci', 'ir.original_invoice_id = ci.id', 'left');
    $this->db->join('customers c', 'ir.customer_id = c.id', 'left');
    $this->db->where('ir.id', $return_invoice_id);
    return $this->db->get()->row();
}



public function get_all_return_invoices() {
    $this->db->select('ir.*, ci.invoiceNo, c.name as customer_name');
    $this->db->from('invoice_returns ir');
    $this->db->join('customer_invoices ci', 'ir.original_invoice_id = ci.id', 'left');
    $this->db->join('customers c', 'ir.customer_id = c.id', 'left');
    $this->db->order_by('ir.return_date', 'DESC');

    return $this->db->get()->result();
}


public function check_Return_InvExist($invoice_id) {
    $this->db->where('original_invoice_id', $invoice_id);
    return $this->db->get('invoice_returns')->row(); // returns null if not found
}

public function update_invoice($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('invoice_returns', $data);
}

public function delete_invoice($id) {
    $this->db->where('id', $id);
    $this->db->delete('invoice_returns');
}


//this is mysql stored procedure write on the db to get the all returned invoices details
/*
    USE qbl_test;

DELIMITER  //

create procedure GetAllReturnInvoices()
begin
	select
		ir.id,
        ir.return_invoice_no,
		ci.invoiceNo AS original_invoice_no,
        ir.return_date,
        ir.customer_id,
        ir.total_return_amount,
        ir.reason,
        c.name as customer_name,
        COUNT(ri.id) as return_count
        
    from invoice_returns ir
    join customers c on c.id = ir.customer_id 
    left join returned_items ri on ri.return_invoice_id = ir.id
	left join customer_invoices ci ON ci.id = ir.original_invoice_id
    group by ir.id
    order by ir.return_date desc;
end //

DELIMITER ;
*/
/*public function GetAllReturnInvoices(){
    $query = $this->db->query("CALL GetAllReturnInvoices()");
   
    return $query->result();
}*/

public function GetAllReturnInvoices() {
    $query = $this->db->query("CALL GetAllReturnInvoices()");
    $result = $query->result();

    // Clean up to allow next stored procedure call
    mysqli_next_result($this->db->conn_id); 
    return $result;
}

public function GetAllReturnInvoicesFilter($from_date = null, $to_date = null, $customer_id = null, $invoice_number = null){
    $this->db->select(
        'ir.id,
        ir.return_invoice_no,
        ci.invoiceNo AS original_invoice_no,
        ir.return_date,
        ir.customer_id,
        ir.total_return_amount,
        ir.reason,
        c.name as customer_name,
        COUNT(ri.id) as return_count
        '
    );
    $this->db->from('invoice_returns ir');
    $this->db->join('customers c', 'c.id = ir.customer_id');
    $this->db->join('returned_items ri', 'ri.return_invoice_id = ir.id', 'left');
    $this->db->join('customer_invoices ci', 'ci.id = ir.original_invoice_id', 'left');

    if(!empty($from_date)){
        $this->db->where('ir.return_date >=', $from_date);
    }

    if(!empty($to_date)){
        $this->db->where('ir.return_date <=', $to_date);
    }

    if(!empty($customer_id)){
        $this->db->where('ir.customer_id', $customer_id);
    }

    if(!empty($invoice_number)){
        $this->db->where('ir.return_invoice_no', $invoice_number);
    }

    $this->db->group_by('ir.id');
    $this->db->order_by('ir.return_date', 'DESC');

    $query = $this->db->get();
    return $query->result();
    
}

public function getAllOriginalInvoiceIds() {
    $this->db->select('original_invoice_id');
    $query = $this->db->get('invoice_returns');
    return array_column($query->result_array(), 'original_invoice_id');
}

/** 
 * Retrieves the total returned invoice amount for each customer, with optional
 * filters based on customer ID and a date range.
 *
 * Used Filters:
 * - $from_date: (optional) Start date to filter return invoices by return_date.
 * - $to_date: (optional) End date to filter return invoices by return_date.
 * - $customer_id: (optional) Specific customer ID to filter by.
 *
 * as a output it return
 * - An array of objects, each containing:
 *   - customer_id
 *   - total_return_amount (sum of all returned amounts for the customer within the filters)
 */

public function get_all_return_invoice_summary($from_date = null, $to_date = null, $customer_id=null){
    $this->db->select('customer_id, SUM(total_return_amount) as total_return_amount');
    $this->db->from('invoice_returns');

    // Apply customer filter
    if(!empty($customer_id)){
      $this->db->where('customer_id', $customer_id);
    }

    // Apply date range filters
    if(!empty($from_date)){
      $this->db->where('return_date >=', $from_date);
    }
    if (!empty($to_date)) {
        $this->db->where('return_date <=', $to_date);
    }


    $this->db->group_by('customer_id');
    $query = $this->db->get();
    return $query->result();
}


public function customer_return_invoice_count($from_date = null, $to_date = null, $customer_id=null){
    $this->db->select('customer_id, COUNT(*) AS return_invoice_count');
    $this->db->from('invoice_returns');

    if(!empty($customer_id)){
      $this->db->where('customer_id', $customer_id);
    }

    // Apply date range filters
    if(!empty($from_date)){
      $this->db->where('return_date >=', $from_date);
    }
    if (!empty($to_date)) {
        $this->db->where('return_date <=', $to_date);
    }

    
    $this->db->group_by('customer_id');

    $query = $this->db->get();
    return $query->result();
}

} 
