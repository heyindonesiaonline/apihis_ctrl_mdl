<?php

// extends class Model
class M_blog extends CI_Model{


    function get_blog()
    {
        $query = $this->db->query("SELECT * FROM blog")->result();
        return $query;
    }
    

    function add_blog($title_blog,$desc_blog,$imageurl,$create_date)
    {
        
        $data = array(
                    'title_blog'=>$title_blog,
					 'desc_blog'=>$desc_blog,
					 'imageurl'=>$imageurl,
					 'create_date'=>$create_date,
					 );
        $postdata = $this->db->insert('blog', $data); 
        
        if($postdata == true)
        {
        
            return array('Status'=>'Success',
					'ResponCode'=>'00'
			);
        }else{
            return array('Status'=>'Failed',
					'ResponCode'=>'01'
			);
        }
        
    }

    function edit_blog($id,$title_blog,$desc_blog,$imageurl,$update_date)
    {

        $data = array(
                    'title_blog'=>$title_blog,
                     'desc_blog'=>$desc_blog,
                     'imageurl'=>$imageurl,
                     'update_date'=>$update_date,
                     );
        $this->db->where('id',$id);
        $postdata = $this->db->update('blog', $data);
        
        if($postdata == true)
        {
            return array('Status'=>'Success',
                    'ResponCode'=>'00'
            );
        }else{
            return array('Status'=>'Failed',
                    'ResponCode'=>'01'
            );
        }

    }


    function delete_blog($id)
    {
        
        $postdata = $this->db->delete('blog', array('id' => $id));
        
        if($postdata == true)
        {
            return array('Status'=>'Success',
                    'ResponCode'=>'00'
            );
        }else{
            return array('Status'=>'Failed',
                    'ResponCode'=>'01'
            );
        }

    }
    
   



}

?>