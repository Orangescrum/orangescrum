<span style="font-family: Arial;font-size:  14px">
    <p><?php echo __("Dear site administrator,");?></p>
	
    <p><?php echo __("Below are the details of the Community Customer who purchased the one-time installation and support for orangescrum community edition,");?></p>
    <p><b><?php echo __("Name:");?></b><?php echo ucwords($data['name']); ?></p>
    <p><b><?php echo __("Email:");?></b><?php echo $data['email']; ?></p>
    <p><b><?php echo __("Industry:");?></b><?php echo $data['industry']; ?></p>
    <p><b><?php echo __("Support Type:");?></b><?php echo __("On-Premises Basic");?><?php echo $data['support_type']; ?></p>
    <p><b><?php echo __("Description:");?></b><p><?php echo nl2br($data['description']); ?></p></p>
    <p><b><?php echo __("Location:");?></b><?php echo $data['location']; ?></p>
    <p><b><?php echo __("GMT Offset:");?></b><?php echo $data['gmt_offset']; ?></p>
        
    <p><?php echo __("Thanks,");?></p>
    <p><?php echo __("The Orangescrum Team");?></p>
</span>
