<?php
  $custom = get_post_custom();
  $options = get_option('discourse');
  $permalink = (string)$custom['discourse_permalink'][0];
  $discourse_url_name = preg_replace("(https?://)", "", $options['url'] );
  $discourse_info = json_decode($custom['discourse_comments_raw'][0]);
  $more_replies = $discourse_info->filtered_posts_count - count($discourse_info->posts) - 1;
  $show_fullname = $options['use-fullname-in-comments'] == 1;

  if($more_replies == 0) {
    $more_replies = "";
  } elseif($more_replies == 1) {
    $more_replies = "1 more reply";
  } else {
    $more_replies = $more_replies . " more replies";
  }

  function homepage($url, $post) {
    echo $url . "/users/" . strtolower($post->username);
  }

  function avatar($template, $size) {
    echo str_replace("{size}", $size, $template);
  }
?>

<?php # var_dump($discourse_info->posts) ?>

<div class="comments span10">
<?php if(count($discourse_info->posts) > 0) { ?>
<div class="comments-heading">
<header class="section-header shadowed">
<h4 id="comments-title"><i class="icon-comments-alt"></i> Notable Replies</h4>
</header>
</div>
<?php } ?>
		<ul class="commentlist">
      <?php foreach($discourse_info->posts as &$post) { ?>
<section class="comment media shadowed">
<div class="pull-left media-object"><img alt="" src="<?php avatar($post->avatar_template,68) ?>" class="avatar avatar-68 photo avatar-default" height="68" width="68"></div>
<div class="media-body">
<header class="media-heading"><h4>
<a href="<?php homepage($options['url'],$post); ?>" rel="external" class="url"><?php echo $post->username; ?></a>
</h4></header>
<div class="content"><?php echo $post->cooked; //var_dump($post);?></div>
<div class="comment-meta commentmetadata">
<i class="icon-time"></i> <time datetime="<?php echo mysql2date("Y-m-d", $post->created_at); ?>"><abbr class="timeago comment-published" title="<?php echo mysql2date("c", $post->created_at); ?>"><?php echo mysql2date(get_option('date_format'), $post->created_at); ?></abbr></time>
</div>
</div>
<footer class="comment-gutter">
		  <a class="btn" href="<?php echo $permalink."/".$post->post_number; ?>"><i class="icon-reply"></i> Reply</a>
          <a class="btn" href="<?php echo $permalink."/".$post->post_number; ?>"><i class="icon-link"></i> Link</a>
</footer>
</section>
      <?php } ?>
		</ul>

		
	
    <div id="respond" class="comments-heading">
<header class="section-header shadowed">
        <h4 id="reply-title"><a href="<?php echo $permalink ?>"><i class="icon-arrow-right"></i> Continue the discussion at Control Command Escape Forums</a></h4>
</header>
</div>
        <?php if(count($discourse_info->posts) > 0) { ?>
        <p class='more-replies'><?php echo $more_replies ?></p>
        <p>
          <?php foreach($discourse_info->participants as &$participant) { ?>
            <img alt="" src="<?php avatar($participant->avatar_template,25) ?>" class="avatar avatar-25 photo avatar-default" height="25" width="25">
          <?php } ?>
        </p>
        <?php } ?>						
</div>
