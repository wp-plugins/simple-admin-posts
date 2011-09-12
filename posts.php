<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="<?php echo plugins_url('jquery.tools.min.js', __FILE__); ?>"></script>
<script src="<?php echo plugins_url('jquery.pajinate.js', __FILE__); ?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo plugins_url('styles.css', __FILE__); ?>" />
<!-- use gif image for IE -->
<!--[if lt IE 7]>
<style>
.tooltip {
 background-image:url('<?php echo plugins_url('black_arrow.gif', __FILE__); ?>');
}
</style>
<![endif]-->
<script type='text/javascript'>
    function submitDel(id){
        document.getElementById("d"+id).submit();
    }
    $(document).ready(function(){
        $('#paging_container').pajinate({
            items_per_page : 10,
            nav_label_first : '<<',
            nav_label_last : '>>',
            nav_label_prev : '<',
            nav_label_next : '>',
            wrap_around: true,
            show_first_last: false
        });
    });   
</script>
<div class="tt">
    <br />
    <br />
    <img src="<?php echo plugins_url('logo.jpg', __FILE__); ?>">
    <br />
    <?php
    global $wpdb;
    $res = $wpdb->get_results("SELECT {$wpdb->prefix}posts.ID,{$wpdb->prefix}posts.post_title,{$wpdb->prefix}users.user_nicename,{$wpdb->prefix}posts.post_type,{$wpdb->prefix}posts.guid,{$wpdb->prefix}posts.post_content from {$wpdb->prefix}posts left outer join {$wpdb->prefix}users on {$wpdb->prefix}users.ID={$wpdb->prefix}posts.post_author where {$wpdb->prefix}posts.post_status='publish' and {$wpdb->prefix}posts.post_type='post' or {$wpdb->prefix}posts.post_type='page' order by {$wpdb->prefix}posts.ID");
    echo '<div class="fix-height-header is420is">Page/Post</div><div class="fix-height-header is80is">Autor</div><div class="fix-height-header is70is">Type</div><div class="fix-height-header is30is">&nbsp;</div><div class="fix-height-header is30is">&nbsp;</div><br clear="all" />';

    echo '<div id="paging_container" class="container"><!--beggin pagination-->
<div class="page_navigation"></div>
<ul class="content">';
    foreach ($res as $r) {
        $replace_content = str_replace('<a', '<a target=\"blank\"', $r->post_content);
        $replace_content = str_replace('"', '&quot;', $replace_content);
        $i++;
        if ($i % 2 == 0) {
            $class = 'odd';
        } else {
            $class = 'even';
        }
        echo '<li><div class="fix-height is420is ' . $class . '" ><a class="link1" href="javascript:void(0);" title=" ' . _($replace_content) . ' ">' . $r->post_title . '</a></div><div class="fix-height is80is ' . $class . '">' . $r->user_nicename . '</div><div class="fix-height is70is ' . $class . '">' . $r->post_type . '</div><div class="fix-height is30is ' . $class . '"><a class="links" href="' . $r->guid . '" target="blank" ><img title="view" class="action" src="' . plugins_url('view.png', __FILE__) . '"></a></div><div class="fix-height is30is ' . $class . '">
<form id="d' . $r->ID . '" style="float:left;" method=POST action=""><input type="hidden" name="del" value="' . $r->ID . '" /><a href="javascript:void(0);" onClick="if(confirm(\'delete?\'))submitDel(\'' . $r->ID . '\');" ><img title="delete" class="action" src="' . plugins_url('delete.png', __FILE__) . '"></a></form></div><br clear="all" /></li>';
    }
    ?>
</ul>	
<div class="page_navigation"></div>
</div><!--end pagination-->	
<script>
    jQuery(".tt .link1[title]").tooltip();
</script>

<?php
global $wpdb;
if (!empty($_POST['del'])) {
    $c = $wpdb->get_row("SELECT * from {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID='$_POST[del]'");
    $str = <<<EOD
INSERT INTO {$wpdb->prefix}simple_admin_posts  (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)VALUES("{$c->ID}","{$c->post_author}","{$c->post_date}","{$c->post_date_gmt}","{$c->post_content}","{$c->post_title}","{$c->post_excerpt}","{$c->post_status}","{$c->comment_status}","{$c->ping_status}","{$c->post_password}","{$c->post_name}","{$c->to_ping}","{$c->pinged}","{$c->post_modified}","{$c->post_modified_gmt}","{$c->post_content_filtered}","{$c->post_parent}","{$c->guid}","{$c->menu_order}","{$c->post_type}","{$c->post_mime_type}","{$c->comment_count}");
EOD;
    $wpdb->query($str);
    $wpdb->query("DELETE from {$wpdb->prefix}posts WHERE {$wpdb->prefix}posts.ID='$_POST[del]'");
    // wp_delete_post($_REQUEST['id']); 
    ?>
    <script>
        window.location = "<?php plugins_url('posts.php', __FILE__); ?>";
    </script>
    <?php
}
?></div><!--tt-->
<sup>The Plugin not renderize flash objects in this version</sup>
