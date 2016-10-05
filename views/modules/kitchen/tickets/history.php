<?php if (isset($activity['history']) && $activity['history']): ?>
    <div class="notice" style="border-bottom: 1px solid <?php echo $activity['history']->status->background_color ?>;">
        <div><span style="background: <?php echo $activity['history']->status->background_color ?>; color: <?php echo $activity['history']->status->font_color ?>;"><?php echo __("tickets:user_updated_ticket", array($activity['history']->user_name, '<strong>'.$activity['history']->status->title.'</strong>', format_date($ts, true))); ?></span></div>
    </div>
<?php endif ?>