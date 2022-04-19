<style type="text/css">
body{font-family:'PT Sans',Arial,sans-serif;color:#666}
.content{min-height:391px;height:auto;margin:0px auto 90px;padding:5px 10px}
h4.chk_head{margin:12px;font-size: 14px;}
.chk_lst_bfr{margin:-4px 15px 12px;font-size:11px;font-weight:normal}
.chk_lst_bfr a{text-decoration:none;cursor:pointer;color:#066D99;}
.chk_lst_bfr a:hover{text-decoration:underline}
.fl{float:left}
.fr{float:right}
.cb{clear:both}
ul.chk_desc{font-size: 13px;line-height: 27px;margin-left:4px;margin-top: -7px;}
ul.chk_desc li a{text-decoration:none;cursor:pointer}
ul.chk_desc li a:hover{text-decoration:underline}
ul.chk_desc.ln20{line-height:20px;margin-left:25px;}
ul.chk_desc.ln20 li b{color:#003165}
</style>
<body>
<div class="content">
    <div>
    	<h4 class="chk_head"><?php echo __('Checklist Before Import');?></h4>
		<div class="chk_lst_bfr"><?php echo __('For Task Group and Task lists, the following are imported');?>:</div>
        <ul class="chk_desc ln20">
            <!--<li><b>Task Group Title - </b> Name of the Task Group</li>
            <li><b>Task Group Description - </b> Description for Task Group. </li>
			<li><b>Start Date - </b> Task Group start date. </li>
			<li><b>End Date - </b> Task Group end date. </li>-->
			<li><b><?php echo __('Title');?> - </b> <?php echo __('Task Title');?> </li>
			<li><b><?php echo __('Description');?> - </b> <?php echo __('Description for the task');?></li>
			<li><b><?php echo __('Due Date');?> - </b> <?php echo __('Due date of Task');?> </li>
			<li><b><?php echo __('Status');?> - </b> <?php echo __('Current status of the Task');?></li>
			<li><b><?php echo __('Type');?> - </b> <?php echo __('Task type(Development, Bug,Enhancement etc.)');?>. </li>
			<li><b><?php echo __('Assign to');?>  - </b> <?php echo __('Valid email of the assign');?>  </li>
        </ul>
		<!--<div class="chk_lst_bfr">Before importing your task group list, you can <a href="<?php echo HTTP_ROOT;?>projects/download_sample_csvfile">download a sample  file</a> to use as a template</div>-->
		<div class="chk_lst_bfr"><?php echo __('Before importing your task group list, you can');?> <a href="<?php echo HTTP_ROOT;?>projects/download_sample_csvfile"><?php echo __('download a sample file');?></a> <?php echo __('to use as a template');?></div>
    </div>
    <div class="cb"></div>
    <div>
    	<h4 class="chk_head">Tips</h4>
        <ul class="chk_desc ln20">
            <li><?php echo __('All text columns has to be enclosed with double quotes');?></li>
            <li><?php echo __('Task title must be a mandatory field');?></li>
			<li><?php echo __('Date must be a valid date with format mm/dd/yyyy,Otherwise treated as current date');?></li>
			<li><?php echo __('In case input task group title has the same name as the existing task group under a project then task will append to that task group');?> </li>
			<li><?php echo __('Status must be anyone out of');?> (<font style="color:#003165"><?php echo __('New,In Progress,resolve,Close');?></font>) ,<?php echo __('Otherwise default treated as');?> <font style="color:#003165"><?php echo __('New');?></font></li>
			<li><?php echo __('Type must be anyone out of');?> (<font style="color:#003165"><?php echo __("Bug,Development,Enhancement,rnd,qa,'Unit Testing',Maintenance,Others,Release,Update");?></font>) ,<?php echo __('Otherwise default treated as');?> <font style="color:#003165"><?php echo __('Development');?></font></li>
        </ul>
    </div>	
</div>
</body>