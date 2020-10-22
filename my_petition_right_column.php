    <div class="right-column right">
        <div class="authorButtons">
            <a href="index"><div class="authorBtn" style="background-image: url('/images/eye.png'); background-size: 28px 28px; background-position: 13px 8px;"><span class="desktop"> View Your Petition</span></div></a>
            <a href="edit"><div class="authorBtn"><span class="desktop"> Edit Your Petition</span></div></a>
            <a href="post_update"><div class="authorBtn" style="background-image: url('/images/megaphone.png'); background-size: 28px 28px; background-position: 13px 8px;"><span class="desktop">Update Your Supporters</span></div></a>
            <a href="download_signatures"><div class="authorBtn" style="background-size: 30px 30px; border-bottom: none; background-position: 11px 8px; background-image: url('/images/download.png');"><span class="desktop">Download signatures</span></div></a>
            <?php
                if($victory == 0){
                    echo ' <a href="declare_victory"><div class="authorBtn" style="background-size: 30px 30px; border-top: 1px solid #dedede; background-position: 11px 8px; background-image: url(\'/images/medal2.png\');"><span class="desktop">Declare victory</span></div></a>';
                    if($closed == 1){
                        echo '<a href="close_petition"><div class="authorBtn" style="border-bottom: none; background-size: 30px 30px; background-position: 11px 8px; background-image: url(\'/images/padlock2.png\');"><span class="desktop">Reopen Your Petition</span></div></a>';
                    }
                    else{
                        echo '<a href="close_petition"><div class="authorBtn" style="border-bottom: none; background-size: 30px 30px; background-position: 11px 8px; background-image: url(\'/images/padlock2.png\');"><span class="desktop">Close Your Petition</span></div></a>';
                    }
                }
                else{
                    if($closed == 1){
                        echo '<a href="close_petition"><div class="authorBtn" style="border-top: 1px solid #dedede; border-bottom: none; background-size: 30px 30px; background-position: 11px 8px; background-image: url(\'/images/padlock2.png\');"><span class="desktop">Reopen Your Petition</span></div></a>';
                    }
                    else{
                        echo '<a href="close_petition"><div class="authorBtn" style="border-top: 1px solid #dedede; border-bottom: none; background-size: 30px 30px; background-position: 11px 8px; background-image: url(\'/images/padlock2.png\');"><span class="desktop">Close Your Petition</span></div></a>';
                    }
                }
            ?> 
        </div>
        <div class="victory-right-column-title">Share Your Petition</div>
        <div class="victory-share-buttons">
            <a class="facebook" target="_blank" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=360')" href="http://www.facebook.com/dialog/feed?caption=www.signandshare.org&display=popup&link=www.signandshare.org/p/<?php echo $path; ?>/&app_id=1411923905492915"><div class="victory-share-btn share-btn-fb"><i class="fa fa-facebook-official" aria-hidden="true"></i></div></a>
            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title . " - Sign the Petition! https://www.signandshare.org/p/" . $path;?> via @signandshare"><div class="victory-share-btn share-btn-twitter twitter-share-button"><i class="fa fa-twitter" aria-hidden="true"></i></div></a>
            <a target="_blank" href="https://plus.google.com/share?url=https://www.signandshare.org/p/<?php echo $path; ?>"><div class="victory-share-btn share-btn-google"><i class="fa fa-google-plus" aria-hidden="true"></i></div></a>
        </div>
        <div class="about-links-holder">
        <div class="victory-right-column-title" style="margin-top: 60px; margin-bottom: 20px;">Petition Tips</div>
            <a href="/guides/how-to-write-a-petition-letter" class="about-link">How to Write a Petition Letter</a>
            <hr class="about-hr">
            <a href="/guides/how-to-promote-your-petition" class="about-link">Promote Your Petition</a>
        </div>
    </div>