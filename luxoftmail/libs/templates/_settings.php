<?php
$tmpl->addItem(
    'text',
    array(
        'name' => 'token',
        'value' => '',
        'label' => __('Token')
    )
);

$tmpl->addItem(
    'text',
    array(
        'name' => 'key',
        'value' => '',
        'label' => __('Key')
    )
);

$tmpl->addItem(
    'button',
    array(
        'value' => __('Save'),
        'name'  => 'save'
    )
);
?>
<div class="col-md-29">
<?php 

$tmpl->template(
    'luxoft-settings-form',
    $tmpl->renderItems()
);

$tmpl->renderPanel(
    array(
        'panel_title'   => $this->view['title'],
        'panel_class'   => 'success',
        'panel_content' => '<div '
            . 'id="settings-form" data-addon_action="settings" '
            . 'data-ads_target="#settings-form" data-ads_template="#luxoft-settings-form"></div>'
    )
);
?>
</div>