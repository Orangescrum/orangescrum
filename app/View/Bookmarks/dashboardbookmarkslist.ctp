    <div class="" style="overflow-y: auto; height:350px;padding:0;margin:0;padding-left:10px; font-size:15px;">
        <div class=''>
        <table class="table p-5">
        
            <tbody>
                <?php
                if(isset($response) && $response['status'] == 1){
                    foreach($response['data'] as $r){
                       
                        if ($r['openin'] != 0) {
                            $target ="_blank";
                        } else {
                            $target ="_self";
                        }
                      
                    ?>
                        <tr><td><a href="<?php echo $r['link'];?>" title="<?php echo $r['link'];?>" target="<?php echo $target;?>"><?php echo $r['title']?></a></td></tr>
                    <?php 
                    }
                }else{
                   ?>
                    <tr class="empty"><td colspan="3" class="text-center"> <img src="<?php echo HTTP_ROOT?>/img/tools/bookmark.svg"" alt=""></td></tr>
                    <tr class="empty"><td colspan="3" class="text-center">Oops! No bookmark found.</td></tr>
                   <?php
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>