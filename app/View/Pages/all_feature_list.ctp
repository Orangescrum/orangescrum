<style>
	.rht_content_cmn.task_lis_page .wrapper {
		padding-top: 70px;
	}

	.selfh_feature_list {
		padding: 40px 0
	}

	.selfh_feature_list .onpremise_type_head {
		position: relative;
		margin: auto;
		text-align: center;
		z-index: 1;
		height: 1px;
		border-top: 1px solid #ddd;
	}

	.selfh_feature_list .onpremise_type_head::before {
		content: '';
		width: 180px;
		height: 2px;
		background: #fff;
		position: absolute;
		left: 0;
		right: 0;
		top: -2px;
		margin: auto;
		pointer-events: none;
		z-index: 1;
	}

	.selfh_feature_list .onpremise_type_head span {
		position: relative;
		display: inline-block;
		width: auto;
		height: 45px;
		font-size: 16px;
		text-transform: uppercase;
		color: #fff;
		line-height: 45px;
		font-weight: 600;
		background: #73d75b;
		padding: 0 30px;
		text-align: center;
		letter-spacing: 4px;
		margin-top: -26px;
		z-index: 11;
	}

	.selfh_feature_list .flex_row {
		margin-top: 60px;
		display: flex;
		width: 100%;
	}

	.selfh_feature_list .flex_row ul {
		display: flex;
		flex-wrap: wrap;
		width: 100%;
		padding: 0 30px;
		margin: 0;
		list-style-type: none;
	}

	.selfh_feature_list .flex_row ul li {
		width: 33.33%;
		display: block;
		margin: 30px 0 0 0;
		font-size: 15px;
		line-height: 20px;
		position: relative;
		padding-left: 60px;
		padding-right: 30px;
		padding-top: 3px;
		text-align: left;
	}

	.selfh_feature_list ul li::before {
		content: '';
		width: 40px;
		height: 40px;
		background: url(<?php echo HTTP_ROOT;?>img/selfhosted-feature-icon.png) no-repeat 0 0;
		display: inline-block;
		position: absolute;
		left: 0;
		top: -10px;
	}

	.selfh_feature_list ul li.tmgmt_li::before {
		background-position: 0 0;
	}

	.selfh_feature_list ul li.cswf_li::before {
		background-position: 0 -52px;
	}

	.selfh_feature_list ul li.urmgmt_li::before {
		background-position: 0 -102px;
	}

	.selfh_feature_list ul li.exrpt_li::before {
		background-position: 0 -152px;
	}

	.selfh_feature_list ul li.resmgmt_li::before {
		background-position: 0 -202px;
	}

	.selfh_feature_list ul li.cf_li::before {
		background-position: 0 -260px;
	}

	.selfh_feature_list ul li.scmmgmt_li::before {
		background-position: -60px 0;
	}

	.selfh_feature_list ul li.gcswf_li::before {
		background-position: -60px -52px;
	}

	.selfh_feature_list ul li.tsmgmt_li::before {
		background-position: -60px -102px;
	}

	.selfh_feature_list ul li.pt_li::before {
		background-position: -60px -152px;
	}

	.selfh_feature_list ul li.kpmgmt_li::before {
		background-position: -60px -202px;
	}

	.selfh_feature_list ul li.tsaprove_li::before {
		background-position: -58px -260px;
	}

	.selfh_feature_list ul li.mapp_li::before {
		background-position: -118px 0;
	}

	.selfh_feature_list ul li.wmgmt_li::before {
		background-position: -118px -52px;
	}

	.selfh_feature_list ul li.inte_li::before {
		background-position: -118px -102px;
	}

	.selfh_feature_list ul li.appc_li::before {
		background-position: -118px -152px;
	}

	.selfh_feature_list ul li.invmgmt_li::before {
		background-position: -118px -202px;
	}

	.selfh_feature_list ul li.pbs_li::before {
		background-position: -118px -260px;
	}
    .center-aligne
    {
        text-align: center;
    }
</style>
<div class="setting_wrapper">
	<div class="selfh_feature_list">
		<h2 class="text-center mb-30"><?php echo __('Upgrade your community edition to Enterprise Self-hosted'); ?></h2><br />
		<div class="onpremise_type_head">
			<span>Premium Features Available in Enterprise Self-hosted</span>
		</div>
		<div class="flex_row">
			<ul>
				<?php $i = 1; foreach($allFeature as $key => $val) {?>
				<li class="<?php echo ($val[0]);?>">
				<a href="<?php echo ($val[2] != '' ?  ORANGESCRUM_URL.$val[2] : '#');?>">
					<?php echo ($val[1]);?>
					</a>
				</li>
				<?php }?>
			</ul>
		</div>

	</div>
	<div class="center-aligne">
		<span >
			<a href="<?php echo SELFHOSTED_UPGRADE; ?>" target="_blank">
				<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info">View all features</button>
			</a>
		</span>
	</div>
</div>