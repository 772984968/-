<?php
return [
    'staticUrl'   => '/style/',
    'login'    => '/login/index',
    'loginOut' => 'login/out',
    'main'     => '/main/index',
    'default'  => '/main/default',

    /*----------- 系统设置 -------------*/
    'system'    => '/system/index',
	'setting'  => '/setting/index',
	'upSetting'  => '/setting/update',
    'upSystem'  => '/system/update',

    'adstype'   => '/system/adstype',
    'addAdstype'=> '/system/addadstype',
    'upAdstype' => '/system/upadstype',
    'delAdstype'=> '/system/deladstype',

	'ads'       => '/system/ads',
    'addAds'    => '/system/addads',
    'upAds'     => '/system/upads',
    'delAds'    => '/system/delads',
	'toupAds' 	=> '/system/toupads',
	'updatecache' => '/system/updatecache',

    /*----------- 权限管理 -------------*/
    'menu'     => '/menu/index',
    'addMenu'  => '/menu/add',
    'upMenu'   => '/menu/edit',
    'delMenu'  => '/menu/delete',
    'adminInfo' => '/admin/info',
    'admin'     => '/admin/index',
    'addAdmin'  => '/admin/add',
    'upAdmin'   => '/admin/edit',
    'delAdmin'  => '/admin/del',
    'adminLogin' => '/admin/adlogin',
    'adminLog'  => '/admin/log',
    'role'      => '/admin/role',
    'addRole'   => '/admin/addrole',
    'upRole'    => '/admin/editrole',
    'delRole'   => '/admin/delrole',
    'label'		=> '/admin/label',
    'upLabel'	=> '/admin/uplabel',

    /*---------- 文章管理 --------------*/
    'articlelist' =>'/article/articlelist',
    'addarticle' =>'/article/addarticle',
    'editarticle' =>'/article/editarticle',
    'delarticle' =>'/article/delarticle',
    'datainput'	=>'/article/datainput',

    /*---------- 文章分类 --------------*/
    'articlecat' => '/articlecat/index',
    'addArticlecat'  => '/articlecat/add',
    'upArticlecat'   => '/articlecat/edit',
    'delArticlecat'  => '/articlecat/delete',
    'pusharticle'	=>'/article/pusharticle',

	/*-------------- 用户信息反馈 ------------------*/
	'feedback' => '/feedback/index',


	/*-------------- APP操作权限管理 ------------------*/
	'apppower' => '/apppower/index',
	'apppowerAdd' => '/apppower/add',
	'apppowerEdit' => '/apppower/edit',
	'apppowerDel' => '/apppower/delete',

	/*-------------- 会员管理 ------------------*/
	'memberManage' => '/member/index',
	'memberAdd' => '/member/add',
	'memberEdit' => '/member/change',
	'memberDel' => '/member/del',

	/*-------------- 积分设置 ------------------*/
	'creditsSetting' => '/setting/index?type=4',
	'vipRewardSetting' => '/setting/index?type=5',
	'rechargeRewardSetting' => '/setting/index?type=6',
	'exchangeSetting' => '/setting/index?type=7',
    'signSetting' => '/setting/signsetting',//

	/*-------------- 会员管理 ------------------*/
	'AccountLevel' => '/accountlevel/index',
	'AccountLevelAdd' => '/accountlevel/add',
	'AccountLevelEdit' => '/accountlevel/change',
	'AccountLevelDel' => '/accountlevel/del',

	/*-------------- 会员价格 ------------------*/
	'MemberPrice' => '/memberprice/index',
	'MemberPricelAdd' => '/memberprice/add',
	'MemberPricelEdit' => '/memberprice/change',
	'MemberPricelDel' => '/memberprice/del',

	/*-------------- 今日头条 ------------------*/
	'hotHeadlinesType' => '/hotheadlinestype/index',
	'hotHeadlinesTypeAdd' => '/hotheadlinestype/add',
	'hotHeadlinesTypeEdit' => '/hotheadlinestype/change',
	'hotHeadlinesTypeDel' => '/hotheadlinestype/del',

	/*-------------- 系统设置的好友信息 ------------------*/
	'systembuddygroup' => '/systembuddygroup/index',
	'systembuddygroupAdd' => '/systembuddygroup/add',


	/*-------------- 系统设置的好友信息 ------------------*/
	'Agentmanage' => '/agentmanage/index',		//代理设置
	'AgentmanageAdd' => '/agentmanage/add',		//代理设置
	'AgentmanageEdit' => '/agentmanage/change',		//代理设置

	'cleaerMember' => '/agentmanage/cleaermember',		//消除会员功能

	/*-------------- 用户管理 ------------------*/
	'UserManage' => '/user/index',
	'UserManageEdit' => '/user/change',
    'UserManageInv'=>'/user/invitations',
    'UserManageRecord'=>'/user/record',
    'UserManageCancel'=>'/user/cancelmember',

	/*-------------- APP端升级 ------------------*/
	'appUpgrade' => '/appupgrade/index',
	'appUpgradeAdd' => '/appupgrade/add',
	'appUpgradeEdit' => '/appupgrade/change',
	'appUpgradeDel' => '/appupgrade/del',

	/*-------------- 直播频道管理 ------------------*/
	'Channel' => '/channel/index',
	'ChannelDel' => '/channel/del',

	/*-------------- VIP视频管理 ------------------*/
	'VipVideo' => '/vipvideo/index',
	'VipVideoAdd' => '/vipvideo/add',
	'VipVideoEdit' => '/vipvideo/change',
	'VipVideoDel' => '/vipvideo/del',
	'VipVideoMAdd' => '/vipvideo/madd',
	/*-------------- 机器人管理 ------------------*/

    'Robotindex' => '/robot/index',
    'Robotadd'=> '/robot/add',
    'RobotEdit'=> '/robot/change',
    'Robotdel'=> '/robot/del',


	/*-------------- 活动管理 ------------------*/
	'ActivityIndex' => '/activity/index',
	'ActivityEdit'	=> '/activity/change',


];
