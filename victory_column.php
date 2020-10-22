    <div class="right-column right">
        <div class="victory-right-column-image"><img alt src="/images/medal.png" width="40px"></div>
        <div class="victory-right-column-title">Confirmed Victory</div>
        <div class="victory-right-column-text">This petition made a difference with <?php echo $currentSupporters; ?> supporters!</div>
        <div class="victory-share-buttons">
            <a class="facebook" target="_blank" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=360')" href="http://www.facebook.com/dialog/feed?caption=www.signandshare.org&display=popup&link=www.signandshare.org/p/<?php echo $path; ?>/&app_id=1411923905492915"><div class="victory-share-btn share-btn-fb"><i class="fa fa-facebook-official" aria-hidden="true"></i></div></a>
            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title . " - Sign the Petition! https://www.signandshare.org/p/" . $path;?> via @signandshare"><div class="victory-share-btn share-btn-twitter twitter-share-button"><i class="fa fa-twitter" aria-hidden="true"></i></div></a>
            <a target="_blank" href="https://plus.google.com/share?url=https://www.signandshare.org/p/<?php echo $path; ?>"><div class="victory-share-btn share-btn-google"><i class="fa fa-google-plus" aria-hidden="true"></i></div></a>
        </div>
        <div class="victory-right-column-second-title">Other urgent petitions:</div>
        <?php
            $otherUrgentPetitions = 'SELECT path, image, title FROM petition WHERE category = "' . $category . '" AND victory = 0 AND closed = 0 AND featured = 1 LIMIT 3';
            $otherUrgentPetitionsQuery = mysqli_query($conn, $otherUrgentPetitions);

            if(!$otherUrgentPetitions){
                die("Error");
                exit;
            }
            else{
                $i = 0;

                while($row = mysqli_fetch_assoc($otherUrgentPetitionsQuery)){
                    $i++;

                    if($i == 3){
                        echo '<div class="victory-other-petition" style="border-bottom: none;">';
                    }
                    else{
                        echo '<div class="victory-other-petition">';
                    }

                    if($row['image'] == ""){
                        echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-img"><img alt src="/images/default.jpg" width="100%" height="100%"></div></a>';
                    }
                    else{
                        echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-img"><img alt src="/images/petitions/' . $row['image'] . '" width="100%" height="100%"></div></a>';
                    }

                    echo '<a href="/p/' . $row['path'] . '/index"><div class="victory-other-petition-title">' . $row['title'] . '</div></a>
                        </div>';
                }
            }
        ?>
        <div class="right-column-start-petition-banner">
            <div class="right-column-start-petition-banner-text">Sign an existing petition or start your own, gain support and help change the world for the better.</div>
            <a href="/start"><div class="start-petition-banner-button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
        </div>
    </div>