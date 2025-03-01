<?php


if (!defined('BASEPATH'))

    exit('No direct script access allowed');


/*
 *	@author : Imran Shah
 *  @support: shahmian@gmail.com
 *	date	: 18 October, 2017
 *	https://phptiger.com
 *  version: 1.0
 */

class General extends CI_Model
{
    function index()
    {
    }

    public function count_all($tbl)
    {
        return $this->db->count_all($tbl);
    }

    //active users
    public function active_users()
    {
        $this->db->select('COUNT(*) as active');
        $this->db->from('usr_user');
        $this->db->where('IS_ACTIVE', 1);
        $sql = $this->db->get();
        //$sql = $this->db->select("SELECT count(1) as active FROM USR_USER WHERE IS_ACTIVE = '1'");
        $query = $sql->row();
        return $query;
    }

    //inactive users
    public function inactive_users()
    {
        $sql = $this->db->query("SELECT count(1) as inactive FROM usr_user WHERE IS_ACTIVE = '0'");
        $query = $sql->row();
        return $query;
    }

    //fetch countries
    public function fetch_countries($limit, $start, $tbl)
    {

        $this->db->limit($limit, $start);

        $query = $this->db->get($tbl);


        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $data[] = $row;
            }

            return $data;
        }

        return false;
    }

    //check child menu count
    public function checkchildMenuCount($pmenuid)
    {


        $whr = array(


            "PARENT_ID" => $pmenuid


        );


        $this->db->where($whr);

        $this->db->from('usr_menu');

        return $this->db->count_all_results();
    }

    // fetching records by single column
    public function fetch_bysinglecol($col, $tbl, $id)
    {


        $where = array(

            $col => $id

        );


        $this->db->select()->from($tbl)->where($where);

        $query = $this->db->get();

        return $result = $query->result();
    }

    //Custom Query function
    public function fetch_CoustomQuery($sql)
    {

        $query = $this->db->query($sql);

        //echo $this->db->last_query();
        return $query->result();
    }

    //find max id
    public function find_maxid($col, $tbl)
    {


        $query = $this->db->query("SELECT ifnull(max($col),'0')

                             as $col FROM `$tbl`");


        return $query->row();
    }


    public function create_record($data, $tbl)
    {


        $this->db->set($data);

        $this->db->insert($tbl);
    }

    //Fetch New Entry with Increment......
    public function fetch_maxid($tbl)
    {


        $this->db->select()->from($tbl);

        $query = $this->db->get();


        return $query->result();
    }


    // Fetch List for records...
    public function fetch_records($tbl)
    {


        $this->db->select()->from($tbl);

        $query = $this->db->get();


        return $query->result();
    }

    //Update Groupe
    public function update_group($group_name, $group_id)
    {


        $update = array(

            "GROUP_NAME" => $group_name

        );


        $this->db->where('GROUP_ID', $group_id);

        return $this->db->update('usr_group', $update);
    }

    //Fetch Group By Id...
    public function fetch_groupbyid($id)
    {

        $where = array(

            "GROUP_ID" => $id

        );

        $this->db->select()->from('usr_group')->where($where);

        $query = $this->db->get();


        return $query->result();
    }

    //Fetch Menu By Id...
    public function fetch_menubyid($id)
    {

        $where = array(

            "MENU_ID" => $id

        );

        $this->db->select()->from('usr_menu')->where($where);

        $query = $this->db->get();


        return $query->result();
    }

    //Update Menu
    public function update_menu()
    {


        extract($_POST);

        $d = date("Y-m-d H:i:s");

        $update = array(

            "MENU_TEXT" => $menu_name,

            "MENU_URL" => $menu_url,

            "PARENT_ID" => $parent_id,

            "SORT_ORDER" => $sort_order,

            "E_USER_ID" => "0",

            "U_DATE_TIME" => $d

        );


        $this->db->where('MENU_ID', $menu_id);

        return $this->db->update('usr_menu', $update);
    }

    // fetch maximum id for permission
    function fetch_permissionmaxno()
    {


        $this->db->select_max('PER_ID');

        $q = $this->db->get('usr_permission');

        $data = $q->row();


        return $data;
    }

    // fetch permission by group
    public function fetch_permissionbygroup($id)
    {

        $where = array(

            "GROUP_ID" => $id

        );

        $this->db->select()->from('usr_permission')->where($where);

        $query = $this->db->get();


        return $query->result();
    }

    //fetch num rows of menus for a group
    public function fetch_per_groupmenu($group_id, $menu_id)
    {

        $where = array(

            "GROUP_ID" => $group_id,

            "MENU_ID" => $menu_id

        );

        $query = $this->db->get_where('usr_permission', $where);


        return $query->num_rows();
    }

    //fetch menus by a group
    public function fetch_groupmenu_id($group_id, $menu_id)
    {

        $where = array(

            "GROUP_ID" => $group_id,

            "MENU_ID" => $menu_id

        );

        $query = $this->db->get_where('usr_permission', $where);


        return $query->result();
    }

    //updating permission records
    public function update_permissionrecord($data, $tbl, $where)
    {


        $this->db->where('PER_ID', $where);

        $this->db->update($tbl, $data);

        return true;
    }

    ////////////////// 03 START ////////////////////////////

    //get single record by id
    public function getbyId($tbl, $where, $select)
    {

        $this->db->select($select);

        $this->db->from($tbl);

        $this->db->where($where);

        $i = $this->db->get();

        return ($i->num_rows > 0) ? $i->row() : array();
    }

    // dynamic query for updating
    function update_record($update, $where, $tbl)
    {

        $this->db->where($where);

        return $this->db->update($tbl, $update);
    }

    //delete records
    public function delete_record($tbl, $whr)
    {


        $this->db->where($whr);

        $this->db->delete($tbl);
    }

    //======  02 starts =========== //
    // flash msg
    public function set_msg($msg = NULL, $msg_type = NULL)
    {

        if ($msg_type == 1) {

            $message = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close'>×</button>
                          $msg
                       </div>";

            $this->session->set_flashdata('msg', $message);
        } else {

            $message = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close'>×</button>
                          $msg
                       </div>";
            $this->session->set_flashdata('msg', $message);
        }
    }


    // ============= 02 ends =========== //

    //selecting and where clause dynamic query
    public function select_where($table, $where, $flag = '')
    {

        $this->db->select();
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        if ($flag == 's')
            return $query->row();
        else
            return $query->result_array();
    }

    public function get_company_info()
    {
        $st = $this->db->select('')->from('company_information')->where('id', 1)->get()->row_array();
        return $st;
    }

    /*===== UPDATE COMPANY INFO =====*/
    public function update_company($data, $id)
    {
        $item = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'address' => $data['address'],
            'website' => $data['website'],
        );
        $this->db->WHERE('id', $id)->update('company_information', $item);
    }

    function check_url_permission($menu_id)
    {
        $c = $this->router->fetch_class();
        $m = $this->router->fetch_method();
        $url = $c . "/" . $m;
        $group_id = $this->session->userdata('group_id');
        $query = $this->db->query("SELECT 
  * 
FROM
  usr_menu AS um, usr_permission AS up 
WHERE um.MENU_ID = '$menu_id' 
AND um.`MENU_ID` = up.`MENU_ID` AND up.`PER_SELECT` = 1
AND up.group_id = $group_id")->result();
        //echo $this->db->last_query();
        if ($query) {
            return $query;
        } else {
            redirect(base_url());
        }
    }

    function check_url_permission_single()
    {
        $c = $this->router->fetch_class();
        $m = $this->router->fetch_method();
        $url = $c . "/" . $m;
        $group_id = $this->session->userdata('group_id');
        $query = $this->db-> query("SELECT 
  * 
FROM
  usr_menu AS um, usr_permission AS up 
WHERE um.MENU_ID = '$url' 
AND um.`MENU_ID` = up.`MENU_ID` AND up.`PER_SELECT` = 1
AND up.group_id = $group_id")->num_rows() > 0;
        //echo $this->db->last_query();
        if ($query > 0) {
            return $query;
        } else {
            $this->session->set_flashdata('error', 'You dont have permission');
            redirect(base_url());
        }
    }

    // get currency name
    public function get_current_currency_name()
    {
        return $st = $this->db->select("")->from('business_settings` as bs, currency_settings as cs')->where('bs.business_settings_id = 4 and bs.`value` = cs.currency_settings_id')->get()->row_array();
    }

    // update currency
    public function update_currency($data)
    {
        $item = array(
            'value' => $data['currency_id'],
        );
        $this->db->WHERE('business_settings_id', 4)->update('business_settings', $item);
    }
}
