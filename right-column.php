<div class="right-column right">
    <a href="/start"><div class="sign-petition-btn center" style="margin-bottom: 60px; margin-top: 0px; padding-top: 13px; height: 20px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Start a petition</div></a>
    <div class="right-column-categories">
        <div class="right-column-petition-feed-title">Categories</div>
        <ul class="right-column-categories-ul left" >
            <li><a href="/animals/index">Animals</a></li>
            <li><a href="/environment/index">Environment</a></li>
            <li><a href="/education/index">Education</a></li>
            <li><a href="/criminal-justice/index">Criminal Justice</a></li>
            <li><a href="/health/index">Health</a></li>
        </ul>
        <ul class="right-column-categories-ul right">
            <li><a href="/womens-rights/index">Women’s Rights</a></li>
            <li><a href="/sustainable-food/index">Sustainable Food</a></li>
            <li><a href="/lgbt-issues/index">LGBT issues</a></li>
            <li><a href="/human-rights/index">Human Rights</a></li>
            <li><a href="/other/index">Other</a></li>
        </ul>
    </div>
    <div class="right-column-petition-feed">
        <div class="right-column-petition-feed-title">Suggested petition</div>
        <?php
            $conn = mysqli_connect($servername,$user,$password,$dbname);
            if($conn == false){
                echo 'ERROR';
                exit;
            }

            $mysqlSuggested = 'SELECT title, image, path FROM petition WHERE featured = 1 AND victory = 0 ORDER BY RAND() LIMIT 1';
            $querySuggested = mysqli_query($conn,$mysqlSuggested);
            if($row = mysqli_fetch_assoc($querySuggested)){
                echo '<a href="/p/' . $row['path'] . '/index"><div class="right-column-petition-feed-image">';
                if($row['image'] == ""){
                    echo '<img alt src="/images/default.jpg" style="border-radius: 2px; width: 100%; height: 100%;">';
                }
                else{
                    echo '<img alt src="/images/petitions/' . $row['image'] . '" style="border-radius: 2px; width: 100%; height: 100%;">';
                }
                echo '</div></a>
                    <a href="/p/' . $row['path'] . '/index"><div class=right-column-petition-feed-petition-title>' . $row['title'] . '</div></a>';
            }
        ?>
    </div>
    <div class="ad-unit-square" style="width: 100%;">
        
        <!-- Sign & Share 300x250 -->
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-6292467664736265"
            data-ad-slot="8955340233"
            data-ad-format="auto"></ins>
        <script>
        });
        </script>
    </div>

    <div class="right-column-petition-feed-title" style="margin-top: 55px;">Join our community</div>
    <div class="fb-like" style="float: left; margin: 10px 8px 8px 0;" data-href="https://www.facebook.com/Sign-Share-173219513163063/?ref=bookmarks" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
    <div style="float: left; margin: 10px 8px 8px 0;"><a href="https://twitter.com/org" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"></a></div><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
