<?php
App::uses('AppModel', 'Model');
class Bookmark extends AppModel {
    public $displayField = 'title';
    public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	/**
	 * create_bookmark
	 * create and update bookmarks
	 * @author swetalina
	 * @author bijay
	 * @param  mixed $data - get all input data for createa bookmark 
	 * @return array
	 */
	public function createBookmark($data){
		$bookmark = array();
		if($data != null){
			if(isset($data['id'])){
				$bookmark['id']=$data['id'];
				$bookmark['title']=$data['title'];
				$bookmark['link']=$data['link'];
				$bookmark['created_by']= SES_ID;
				$bookmark['open_in_same_page']=$data['pages'];
				$bookmark['created'] = date('Y-m-d H:i:s');
				$response = $this->save($bookmark);
			}else{
				$this->create();  
				$bookmark['title']=$data['title'];
				$bookmark['link']=$data['link'];
				$bookmark['created_by']= SES_ID;
				$bookmark['open_in_same_page']=$data['pages'];
				$bookmark['created'] = date('Y-m-d H:i:s');
				$response = $this->save($bookmark);
			}
	
			return $response;
		}
	}	
	/**
	 * edit_bookmark
	 * edit bookmark by using bookmark id
	 * @param  mixed $sid - bookmark id
	 * @author swetalina
	 * @author bijay
	 * @return void
	 */
	public function editBookmark($sid){
		if(isset($sid) && $sid != null){
			$response = $this->find('first',array('conditions'=>array('Bookmark.id'=>$sid)));
			return $response;
		}
	}	
	/**
	 * bookmarkDetails
	 * author Bijaya
	 * @return void
	 * @author bijay
	 * @data 21/08/2021
	 */ 
	public function bookmarkDetails(){
		$data = array();
		$data['status']= false;
		$response = $this->find('all' ,array('conditions' => array('Bookmark.created_by' => SES_ID),'order' => 'Bookmark.id DESC' ));
	    $count = count($response);
	   if($count > 0){
		$data['status']= true;
		foreach($response as $k => $v){
			if($v['Bookmark']['title'] != null){
				$data['data'][] = array(
					'id'=>$v['Bookmark']['id'],
					'link'=>$v['Bookmark']['link'],
					'title'=>$v['Bookmark']['title'],
					'openin'=>$v['Bookmark']['open_in_same_page']
				);
			}
		}
		return $data;
	   }
		
	}	
	/**
	 * bookmarkDelete
	 * delete single record of bookmark in bookmark list 
	 * @param  mixed $id - bookmark id
	 * @author swetalina 
	 * @author bijay 
	 * @date 23/08/2021
	 * @return boolean
	 */
	public function bookmarkDelete($id){
		if($id != null){
			$result = $this->find('first',array('conditions'=>array('Bookmark.id'=>$id)));
            if($result){
                $this->id = $id;
                if($this->delete()){
                   return true;
                }else{
					return false;
				}
            }else{
				return false;  
			}
		}
	}	
	/**
	 * reorderBookmarkList
	 * reorder of list by drag and drop
	 * @param  mixed $bookmark_tr
	 * @author swetalina
	 * @author bijay
	 * data - 23/08/2021
	 * @return boolean
	 */
	public function reorderBookmarkList($bookmark_tr){
		if($bookmark_tr != null){
			foreach($bookmark_tr as $k=>$v){
			$this->create();
			$this->id = $v;
			$this->saveField('seq',($k+1));
		}
			return true;
		}else{
			return false;
		}
		
	}
}
?>