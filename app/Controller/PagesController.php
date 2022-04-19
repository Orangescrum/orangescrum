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
class PagesController extends AppController {
 	public $name = 'Pages';
	public $components = array('RequestHandler', 'Sendgrid');
	public $helpers = array('Text');
	public function feed() 
	{
		$this->layout='rss/default_outer';
		//if ($this->RequestHandler->isRss()) {
			$this->loadModel('ProductUpdate');
			$posts = $this->ProductUpdate->find(
				'all',
				array('conditions' => array('ProductUpdate.status' => 1),'limit' => 50, 'order' => 'ProductUpdate.created DESC')
			);
			$this->set(compact('posts'));
			$this->render('rss/index');
			return true;
		//}
	}
	public function display($page = null)
	{
		$this->render("pages/".$page);
	}
	public function allFeatureList()
    {
        $allFeature = [
			0 => ['tmgmt_li', 'Time Management', 'time-tracking'],
			1 => ['cswf_li', 'Custom Workflows', 'custom-status-workflow'],
			2 => ['urmgmt_li', 'User Role Management', 'user-role-management'],
			3 => ['exrpt_li', 'Executive Reports', 'project-reports-analytics'],
			4 => ['resmgmt_li', 'Resource Management', 'resource-management'],
			5 => ['cf_li', 'Custom fields', 'custom-fields'],
			6 => ['scmmgmt_li', 'Scurm Project Management', 'agile-project-management'],
			7 => ['gcswf_li', 'Gantt Chart', 'gantt-chart'],
			8 => ['tsmgmt_li', 'Task Management', 'task-management'],
			9 => ['pt_li', 'Project Templates', 'project-template'],
			10 => ['kpmgmt_li', 'Kanban Project Management', 'kanban-view'],
			11 => ['tsaprove_li', 'Timesheet approval', 'timesheet'],
			12 => ['inte_li', 'Integrations', 'integrations'],
			13 => ['invmgmt_li', 'Invoice Management', 'invoice-how-it-works'],
			14 => ['pbs_li', 'Project Budget & cost', 'budget-and-cost-management'],
			
		];
		$total = count($allFeature)%3;
		$total_loop = count($allFeature)/3;
		
        $this->set('allFeature', $allFeature);
        $this->set('total', $total);
        $this->set('total_loop', $total_loop);
    }
}