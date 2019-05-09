<?php

namespace models\vendor;

/**
 * Description of adsTemplateRender
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:32:22 AM
 */
class adsTemplateRender
{

    /**
     * Render panel
     * @param array $args <p>
     * panel-title-icon, panel-title, panel-description, panel-class, panel-content
     * </p>
     *
     * @return string
     */
    public function panel($args = array())
    {
        $defaults = array(
            'panel-title-icon'  => false,
            'panel-title'       => false,
            'panel-heading'     => false,
            'panel-help'        => false,
            'panel-description' => false,
            'panel-class'       => 'default',
            'panel-content'     => '',
        );

        $args = \wp_parse_args($args, $defaults);
        if ($args['panel-help']) {
            $help = sprintf(
                '<span class="status-mark border-light-green"></span> <a href="%s" target="_blank" class="help-link">%s</a>',
                esc_url($args[ 'panel-help' ]),
                __('How it works')
            );

            if ($args['panel-heading']) {
                $args['panel-heading'] .= $help;
            } else {
                $args['panel-heading'] = $help;
            }
        }

        $content = sprintf(
            '<div class="panel panel-%s">%s<div class="panel-body">%s %s</div></div>',
            $args['panel-class'],
            $args['panel-title'] || $args['panel-heading'] ?
                sprintf(
                    '<div class="panel-heading">%s%s</div>',
                    $args['panel-title'] ? sprintf('<h5 class="panel-title">%s%s</h5>',
                    $args['panel-title-icon'] ? '<i class="fa fa-' . $args['panel-title-icon'] . '"></i>&nbsp;' : '',
                    $args['panel-title']) : '',
                    $args['panel-heading'] ? sprintf('<div class="heading-elements">%s</div>', $args['panel-heading']) : ''
                ) : '',
            $args['panel-description'] ? '<p>' . $args['panel-description'] . '</p>'  : '',
            $args['panel-content']
        );

        return $content;
    }

    /**
     * item
     * 
     * @param type $type
     * @param type $args
     * @return type
     */
    public function item($type, $args)
    {
        if (method_exists($this, $type)) {
            return $this->$type($args);
        }

        return null;
    }
 
    /**
     * Render text element
     * @param array $args <p>
     * label, class, id, name, value, placeholder, disabled, help
     * </p>
     *
     * @param array $args
     *
     * @return string
     */
    public function text($args = array())
    {
        $defaults = array(
            'label'       => false,
            'class'       => 'form-control',
            'id'          => false,
            'name'        => false,
            'value'       => false,
            'placeholder' => false,
            'disabled'    => false,
            'help'        => false,
        );

        $args = \wp_parse_args($args, $defaults);

        if (!$args['id'] && $args['name']) {
            $args['id'] = $args['name'];
        }

        if (!$args['value'] && $args['name']) {
            $args['value'] = '{{' . $args['name'] .'}}';
        }

        if ($args['value'] == 'null') $args['value'] = '';

        $content = sprintf(
            '<div class="form-group">%s<input type="text" class="form-control %s" id="%s" name="%s" value="%s" placeholder="%s" %s>%s</div>',
            $args['label'] ? '<label for="' . $args['id'] . '">' . $args['label'] . '</label>' : '',
            $args['class'],
            $args['id'],
            $args['name'],
            $args['value'],
            $args['placeholder'],
            $args['disabled'] ? 'disabled="disabled"' : '',
            $args['help'] ? '<span class="help-block">' . $args['help'] . '</span>' : ''
        );

        return $content;
    }

    /**
     * button
     * 
     * @param type $args
     * @return type
     */
    public function button($args = array())
    {
        $defaults = array(
            'class'      => 'btn btn-blue',
            'value'      => __('Submit'),
            'name'       => false,
            'id'         => false,
            'form_group' => false,
            'data'       => array()
        );

        $args = \wp_parse_args($args, $defaults);
        $buttonData = '';
        foreach ($args['data'] as $key => $value) {
            $buttonData .= 'data-' . $key . ' = ' . $value . ' ';
        }

        $content = sprintf(
            '<div class="%s"><button class="btn btn-blue addon-button %s" id="%s" data-dismiss="modal" name="%s" %s>%s</button></div>',
            $args['form_group'] ? 'form-group' : 'text-right',
            $args['class'],
            $args['id'],
            $args['name'],
            $buttonData,
            $args['value']
        );

        return $content;
    }
}