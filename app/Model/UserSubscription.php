<?php

class UserSubscription extends AppModel {

    var $name = 'UserSubscription';
	
	/**
     * @method public Get_billing_info(int account_id)
     * @author Andola Dev <support@andolacrm.com>
     */
	public function readSubDetlfromCache($comp_id, $data_sub = null) {
		//Cache::delete('sub_detl_'.$comp_id);
		if (($sub_detl = Cache::read('sub_detl_'.$comp_id)) === false) {
			if(empty($data_sub)){
				$data_sub = $this->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => 'id DESC'));
			}
			Cache::write('sub_detl_'.$comp_id, $data_sub);
		}else{
			if(!empty($data_sub)){
				Cache::delete('sub_detl_'.$comp_id);
				Cache::write('sub_detl_'.$comp_id, $data_sub);
			}
		}	
		return Cache::read('sub_detl_'.$comp_id);
	}
    /**
     * @method private getstatistics() Get statistics of users
     * @return array Statistics value in an array
     * @author GDR<abc@mydomain.com>
     */
    function getstatistics($today = 0) {
        /* $sql = "SELECT COUNT(u.id) as cnt,u.subscription_id FROM 
          (SELECT  us.* FROM
          ( SELECT MAX(id) AS mid FROM user_subscriptions GROUP BY company_id ) u
          JOIN user_subscriptions us  ON us.id = u.mid ) AS u ,
          companies c WHERE c.id = u.company_id AND c.is_active=1 AND u.is_free!=1 AND u.is_cancel!=1 GROUP BY u.subscription_id";
          $data = $this->query($sql);
          foreach ($data AS $key =>$val){
          //$comp_st[$val['u']['subscription_id']]=$val[0]['cnt'];
          } */
        //return $comp_st;
        //Today's Parameter is passed only for API call for IOS applications
        $cond = " 1 ";
        if ($today) {
            $cond = " DATE(c.created)='" . GMT_DATE . "' ";
        }
        //$sql1 = "SELECT MAX(u.subscription_id) as maxsid , MIN(u.subscription_id) minsid,us.isactive AS status FROM companies c ,user_subscriptions u,users us WHERE u.company_id = c.id AND u.user_id=us.id AND (us.isactive=1 OR us.isactive=2) AND c.is_active=1 AND c.name NOT LIKE '%AndolaTest%' AND u.is_free!=1 AND ".$cond." GROUP BY u.company_id ORDER BY `maxsid`  DESC";
        //changed the query as the free sub id is now 9 instead of 1
        $sql1 = "SELECT MAX(u.id) as maxid , MIN(u.id) minid, us.id AS uid, us.isactive AS status FROM companies c ,user_subscriptions u,users us WHERE u.company_id = c.id AND u.user_id=us.id AND (us.isactive=1 OR us.isactive=2) AND c.is_active=1 AND c.name NOT LIKE '%AndolaTest%' AND u.is_free!=1 AND u.temp_sub_cancel !=1 AND " . $cond . " GROUP BY u.company_id ORDER BY `maxid`  DESC";
        $data1 = $this->query($sql1);
        $uids = Hash::extract($data1, '{n}.us.uid');

        $total_user_sql = 'SELECT count(id) as cnt FROM users WHERE isactive != 3';
        $total_user = $this->query($total_user_sql);
        //$total_useruids = Hash::extract($total_user, '{n}.users.id');
        //$result=array_diff($total_useruids,$uids);                
        //echo "<pre>";print_r($total_user); print_r($uids);print_r($data1);exit;
        //arranging subscription.id
        $sidArr = array();
        foreach ($data1 as $key => $v) {
            $sidArr[] = $v[0]['maxid'];
            $sidArr[] = $v[0]['minid'];
        }

        //getting subscription_id
        $sql2 = "SELECT UserSubscription.id,UserSubscription.subscription_id FROM user_subscriptions UserSubscription WHERE UserSubscription.id IN (" . implode(',', $sidArr) . ")";
        $res_sid = $this->query($sql2);
        $subArr = array();
        foreach ($res_sid as $v) {
            $subArr[$v['UserSubscription']['id']] = $v['UserSubscription']['subscription_id'];
        }
        $ALL_FREE_plans = Configure::read('ALL_FREE_PLANS');
        array_push($ALL_FREE_plans, 13);
        $comp_st['pending'] = 0;
        $comp_st[1] = 0;
        $comp_st[2] = 0;
        $minconvs[1] = 0;
        $minconvs[2] = 0;
        $comp_st['conv_per'] = 0;
        $comp_st['total_conv'] = 0;
        foreach ($data1 as $key => $v) {
            if ($v['us']['status'] == 1) {
                if (in_array($subArr[$v[0]['maxid']], $ALL_FREE_plans)) {
                    $comp_st[1] = $comp_st[1] ? ($comp_st[1] + 1) : 1;
                } else {
                    $comp_st[2] = $comp_st[2] ? ($comp_st[2] + 1) : 1;
                }
                $minconvs[$subArr[$v[0]['minid']]] = $minconvs[$subArr[$v[0]['minid']]] + 1;
            } else {
                $comp_st['pending'] +=1;
            }
        }
        if ($minconvs[1] > 0 || $minconvs[9] > 0 || $minconvs[11] > 0 || $minconvs[13] > 0) {
            $conv_basic_to_paid = round(((($minconvs[1] + $minconvs[9] + $minconvs[11] + $minconvs[13] - $comp_st[1]) / ($minconvs[1] + $minconvs[9] + $minconvs[11] + $minconvs[13])) * 100), 2);
            $comp_st['conv_per'] = $conv_basic_to_paid;
            $comp_st['total_conv'] = ($minconvs[1] + $minconvs[9] + $minconvs[11] + $minconvs[13] - $comp_st[1]);
        }
        $comp_st['signedup_user'] = count($uids);
        $comp_st['totalos_users'] = $total_user[0][0]['cnt'];
        return $comp_st;
    }

    function getydata($dt_arr) {
        foreach ($dt_arr as $key => $date) {
            //for checknai kolkata timezone only
			$date_st = date('Y-m-d', strtotime('-1 day',strtotime($date))).' 18:30:00';
			$date_edt = date('Y-m-d', strtotime($date)).' 18:29:59';
			
            //$ydata = $this->query("SELECT COUNT(u.id) as cnt , u.subscription_id FROM user_subscriptions u, companies c WHERE u.company_id = c.id AND DATE(u.created) ='" . $date . "' AND c.is_active=1 AND u.is_free!=1 AND u.temp_sub_cancel !=1 GROUP BY u.subscription_id");
            $ydata = $this->query("SELECT COUNT(u.id) as cnt , u.subscription_id FROM user_subscriptions u, companies c WHERE u.company_id = c.id AND u.created >'" . $date_st . "' AND u.created <='" . $date_edt . "' AND c.is_active=1 AND u.is_free!=1 AND u.temp_sub_cancel !=1 GROUP BY u.subscription_id");
            $ydata_list = Set::combine($ydata, '{n}.u.subscription_id', array('{0} {1}', '{n}.0.cnt'));
            $ydata_list[1] = $ydata_list[1] ? (int) $ydata_list[1] : 0;
            $ydata_list[9] = $ydata_list[9] ? (int) $ydata_list[9] : 0;
            $ydata_list[11] = $ydata_list[11] ? (int) $ydata_list[11] : 0;
            $ydata_list[13] = $ydata_list[13] ? (int) $ydata_list[13] : 0;

            $data['free'][] = $ydata_list[1] + $ydata_list[9] + $ydata_list[11] + $ydata_list[13];
            $data['startup'][] = $ydata_list[10] ? (int) $ydata_list[10] : 0;
            $data['basic'][] = $ydata_list[5] ? (int) $ydata_list[5] : 0;
            $data['standard'][] = $ydata_list[12] ? (int) $ydata_list[12] : 0;
            $data['professional'][] = $ydata_list[14] ? (int) $ydata_list[14] : 0;
            $data['team'][] = $ydata_list[6] ? (int) $ydata_list[6] : 0;
            $data['business'][] = $ydata_list[7] ? (int) $ydata_list[7] : 0;
            //$data['premium'][] = $ydata_list[8]?(int)$ydata_list[8]:0;
        }
        return $data;
    }
}