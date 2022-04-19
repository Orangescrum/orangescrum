<?php
/*************************************************************************	
 * Orangescrum Community Edition is a web based Project Management software developed by
 * Orangescrum. Copyright (C) 2013-2022
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): THERE IS NO WARRANTY FOR THE PROGRAM, * TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN   
 * WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS"
 * WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT 
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 * PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE
 * PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
 * ALL NECESSARY SERVICING, REPAIR OR CORRECTION..
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street Fifth Floor, Boston, MA 02110,
 * United States.
 *
 * You can contact Orangescrum, 2059 Camden Ave. #118, San Jose, CA - 95124, US. 
   or at email address support@orangescrum.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Orangescrum" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Orangescrum".
 *****************************************************************************/
App::uses('AppController', 'Controller');
App::import('Vendor', 'oauth');
class BookmarksController extends AppController {    
    /**
     * bookmarksList
     * fetch and show all the bookmarks in bookmark list page
     * add new bookmark
     * @author swetalina
     * data - 10/08/2021
     * @return array
     */
    public function bookmarksList(){
        if(isset($this->request->data['list'])){
            $bookmark_list = $this->Bookmark->find('all',array('conditions' => array('Bookmark.created_by' => SES_ID), 'order'=>array('Bookmark.seq'=>'DESC')));
            $this->set('bookmark_list',$bookmark_list);
            $this->render('/Elements/bookmarks_list', 'ajax');
        }
    }
		/**
     * createBookmark
     * 
     * add new bookmark
     * @author swetalina
     * data - 10/08/2021
     * @return array
     */
    public function createBookmark(){
            $data = $this->request->data;
        if($this->request->is('post')){
            $bookmark = $this->Bookmark->createBookmark($data);
            echo json_encode($bookmark);
            exit;
        }
    }
    /**
     * editBookmark
     * edit the single row of  bookmarks list
     * @author swetalina
     * @return array
     * date - 10/08/2021
     */
    public function editBookmark(){
        if($this->request->is('post')){
            if(isset($this->request->data['sid'])){
                $sid = $this->request->data['sid'];
                $result = $this->Bookmark->editBookmark($sid);
                echo json_encode($result);
                exit;
            }else{
                $data = $this->request->data;
                $bookmark = $this->Bookmark->createBookmark($data);
                echo json_encode($bookmark);
                exit;
            }
        }
    }
    
    /**
     * deleteBookmark
     * delete a single bookmark of bookmark list
     * @author swetalina
     * @return array
     * date - 10/08/2021
     */
    public function deleteBookmark(){
        $arr['msg'] = __("Oops! Something went wrong",true);
        $arr['status'] = false;
        if(isset($this->request->data['id']) && !empty($this->request->data['id']) ){
            $id = $this->request->data['id'];
            $result = $this->Bookmark->bookmarkDelete($id);
            if($result){
                $arr['msg'] = __("Bookmark deleted successfully.",true);
                $arr['status'] =true;  
            }
            echo json_encode($arr);
            exit;
        }
    }
    /**
     * reorderBookmark
     * reorder the bookmarks of bookmarks list
     * @author swetalina 
     * @return array
     * date - 11/08/2021
     */
   public function reorderBookmark(){
        $arr['status'] = false;
        if(isset($this->request->data['custom_bookmark_tr'])){
            $bookmark_tr = $this->request->data['custom_bookmark_tr'];
            // $listStst = $this->Bookmark->find('list', array('conditions' => array('Bookmark.id' => $this->request->data['custom_bookmark_tr'])));
            $listStst = $this->Bookmark->reorderBookmarkList($bookmark_tr);
            if($listStst){
                $arr['status'] =true;
            }
        }
        echo json_encode($arr);
        exit;
    }    
    /**
     * dashboardBookmarksList
     * fetch and show all the bookmarks in dashboard
     * @author bijay
     * @return array
     * date - 21/08/2021
     */
    public function dashboardBookmarksList(){
       $this->layout ="ajax";
       $this->loadModel('Bookmark');
       $response = $this->Bookmark->bookmarkDetails();
       $this->set('response', $response);
    }
}
?>