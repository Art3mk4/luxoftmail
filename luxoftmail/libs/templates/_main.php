<?php
$tmpl->addItem(
    'text',
    array(
        'name' => 'address',
        'value' => '',
        'label' => __('Address')
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
    'luxoft-main-form',
    $tmpl->renderItems()
);

$tmpl->renderPanel(
    array(
        'panel_title'   => $this->view['title'],
        'panel_class'   => 'success',
        'panel_content' => '<div '
            . 'id="main-form" data-addon_action="main" '
            . 'data-ads_target="#main-form" data-ads_template="#luxoft-main-form"></div>'
    )
);
?>
</div>