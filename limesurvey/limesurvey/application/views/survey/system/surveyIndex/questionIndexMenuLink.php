<?php
/**
 * $type integer
 * $indexItems array[]
 *
 */
?>
<li class="dropdown ls-no-js-hidden index-menu-<?php echo ($type>1)? 'full':'incremental' ?>">
    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <?php echo gT("Question index"); ?>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <?php foreach($indexItems as $group): ?>
            <li>
                <div class="dropdown-header">
                    <?php echo viewHelper::flatEllipsizeText($group['text'],true,30," &hellip; ",0.6); ?>
                    <span class="caret"></span>
                </div>
                <ul class="dropdown-menu dropdown-sub-menu">
                <?php foreach($group['questions'] as  $step=>$indexItem): ?>
                    <?php
                        /* bs class for testing : bg-danger is really great here, but only if menu is set in navigator or after */
                        $statusClass = $indexItem['stepStatus']['index-item-unanswered']? " bg-warning":"";
                        $statusClass.= $indexItem['stepStatus']['index-item-error']? " bg-danger":"";
                        $statusClass.= $indexItem['stepStatus']['index-item-current']? " disabled":"";
                    ?>
                    <li class="<?php echo $indexItem['coreClass']; ?><?php echo $statusClass; ?>">
                        <a href='<?php echo $indexItem['url']; ?>' data-limesurvey-submit='<?php echo $indexItem['submit']; ?>'>
                            <?php echo viewHelper::flatEllipsizeText($indexItem['text'],true,30," &hellip; ",0.6); ?>
                        </a>
                    </li>
                <?php endforeach;?>
                </ul>
            </li>
        <?php endforeach;?>
    </ul>
</li>

