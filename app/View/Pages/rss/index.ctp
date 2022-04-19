<?php
$this->set('channelData', array(
    'title' => __("Most Recent updates"),
    'link' => $this->Html->url('/', true),
    'description' => __("Most recent updates."),
    'language' => 'en-us'
));
if($posts){
foreach ($posts as $post) {
    $postTime = strtotime($post['ProductUpdate']['created']);
	//$post['ProductUpdate']['slug'] = '#'.'12';
    $postLink = array(
        'controller' => 'pages',
        'action' => 'view',
        'year' => date('Y', $postTime),
        'month' => date('m', $postTime),
        'day' => date('d', $postTime),
        $post['ProductUpdate']['slug']
    );

    // Remove & escape any HTML to make sure the feed content will validate.
    $bodyText = h(strip_tags($post['ProductUpdate']['description'])); 
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));
	if($post['ProductUpdate']['type'] == 'update'){
		$post['ProductUpdate']['title'] = 'Functionalities updated';
	}else if($post['ProductUpdate']['type'] == 'new'){
		$post['ProductUpdate']['title'] = 'New Functionality has been added';
	}else{
		$post['ProductUpdate']['title'] = 'Issues have been resolved';
	}
    echo  $this->Rss->item(array(), array(
        'title' => $post['ProductUpdate']['title'],
        'link' => 'https://www.orangescrum.com/updates',//$postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $post['ProductUpdate']['created']
    ));
}
}


?>