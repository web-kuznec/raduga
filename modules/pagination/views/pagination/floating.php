<?php
/*
	First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
*/

// Number of page links in the begin and end of whole range
$count_out = ( ! empty($config['count_out'])) ? (int) $config['count_out'] : 3;
// Number of page links on each side of current page
$count_in = ( ! empty($config['count_in'])) ? (int) $config['count_in'] : 5;

// Beginning group of pages: $n1...$n2
$n1 = 1;
$n2 = min($count_out, $total_pages);

// Ending group of pages: $n7...$n8
$n7 = max(1, $total_pages - $count_out + 1);
$n8 = $total_pages;

// Middle group of pages: $n4...$n5
$n4 = max($n2 + 1, $current_page - $count_in);
$n5 = min($n7 - 1, $current_page + $count_in);
$use_middle = ($n5 >= $n4);

// Point $n3 between $n2 and $n4
$n3 = (int) (($n2 + $n4) / 2);
$use_n3 = ($use_middle && (($n4 - $n2) > 1));

// Point $n6 between $n5 and $n7
$n6 = (int) (($n5 + $n7) / 2);
$use_n6 = ($use_middle && (($n7 - $n5) > 1));

// Links to display as array(page => content)
$links = array();

// Generate links data in accordance with calculated numbers
for ($i = $n1; $i <= $n2; $i++)
{
	$links[$i] = $i;
}
if ($use_n3)
{
	$links[$n3] = '&hellip;';
}
for ($i = $n4; $i <= $n5; $i++)
{
	$links[$i] = $i;
}
if ($use_n6)
{
	$links[$n6] = '&hellip;';
}
for ($i = $n7; $i <= $n8; $i++)
{
	$links[$i] = $i;
}

?>
<p class="pagination">страницы: 

	<?php if($first_page !== FALSE){ 
            $url = HTML::chars($page->url($first_page));
            if(strpos($url, "?")) {
                if(strpos($url, "/?") === FALSE) {
                    $url = str_replace("?", "/?", $url);
                } ?>
                <a href="<?php echo $url; ?>" rel="first"><?php echo __('&laquo;') ?></a> <?php
            } else { ?>
		<a href="<?php echo $url; ?>/" rel="first"><?php echo __('&laquo;') ?></a>
            <?php }
	 } else { ?>
		<?php echo __('&laquo;') ?>
	<?php } ?>

	<?php if ($previous_page !== FALSE) { 
                $previous = HTML::chars($page->url($previous_page));
                if(strpos($previous, "?")) {
                    if(strpos($previous, "/?") === FALSE) {
                        $previous = str_replace("?", "/?", $previous);
                    }
                }
                ?>
		<a href="<?php echo $previous; ?>" rel="prev"><?php echo __('&lt;') ?></a>
	<?php } else { ?>
		<?php echo __('&lt;') ?>
	<?php } ?>

	<?php foreach ($links as $number => $content): ?>

		<?php if ($number === $current_page) { ?>
			<strong><?php echo $content ?></strong>
		<?php } else { 
                        $num = HTML::chars($page->url($number));
                        if(strpos($num, "?")) {
                            if(strpos($num, "/?") === FALSE) {
                                $num = str_replace("?", "/?", $num);
                            }
                        } 
                        ?>
                        <?php if($content == "1") { ?>
                            <a href="<?php echo $num; ?>/"><?php echo $content ?></a>
                        <?php } else { ?>
                            <a href="<?php echo $num; ?>"><?php echo $content ?></a>
                        <?php } ?>
		<?php } ?>

	<?php endforeach ?>

	<?php if ($next_page !== FALSE) { 
                $next = HTML::chars($page->url($next_page));
                if(strpos($next, "?")) {
                    if(strpos($next, "/?") === FALSE) {
                        $next = str_replace("?", "/?", $next);
                    }
                } 
                ?>
		<a href="<?php echo $next; ?>" rel="next"><?php echo __('&gt;') ?></a>
	<?php } else { ?>
		<?php echo __('&gt;') ?>
	<?php } ?>

	<?php if ($last_page !== FALSE) { 
                $last = HTML::chars($page->url($last_page));
                if(strpos($last, "?")) {
                    if(strpos($last, "/?") === FALSE) {
                        $last = str_replace("?", "/?", $last);
                    }
                } 
                ?>
		<a href="<?php echo $last; ?>" rel="last"><?php echo __('&raquo;') ?></a>
	<?php } else { ?>
		<?php echo __('&raquo;') ?>
	<?php } ?>

</p><!-- .pagination -->