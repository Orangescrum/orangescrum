<ul id="help_srch">
    <?php if(is_array($getSearchResult) && !empty($getSearchResult)){ ?>
    <?php foreach ($getSearchResult as $key => $value) { ?>
        <li class="active">
            <?php $subject = preg_replace('/[\s]+/','-',preg_replace('/[&]+/','',strtolower($value['Help']['title'])));?>
            <a href="<?php echo KNOWLEDGEBASE_URL.$subject;?>" target="_blank" style="outline:none;"><?php echo $value['Help']['title'];?></a>	
        </li>
    <?php } ?>
    <?php } else { ?>
        <li class="active">No matches found.</li>
    <?php } ?>
</ul>