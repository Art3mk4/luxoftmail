<?php

namespace models\vendor;

/**
 * Description of adsTemplate
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:32:22 AM
 */
class adsTemplate extends adsTemplateRender
{

    private $panel_title_icon  = false;
    private $panel_title       = false;
    private $panel_heading     = false;
    private $panel_help        = false;
    private $panel_description = false;
    private $panel_class       = false;
    private $panel_content     = false;

    /**
     * Type of element
     * @var bool|string
     */
    private $type         = false;

    /**
     * Label for element
     * @var bool|string
     */
    private $label        = false;

    /**
     * Class of element
     * @var bool|string
     */
    private $class        = false;

    /**
     * true/false Class for parent element
     * @var bool|string
     */
    private $form_group   = false;

    /**
     * Id of element
     * @var bool|string
     */
    private $id           = false;

    /**
     * Name of element
     * @var bool|string
     */
    private $name         = false;

    /**
     * Multiple for select
     * @var bool|string
     */
    private $multiple     = false;

    /**
     * value like {{some.param}} or use false to show {{name}}
     * @var bool|string
     */
    private $value        = false;

    /**
     * values for select
     * @var bool|string
     */
    private $values       = false;

    /**
     * Attribute checked for radio and checkbox elements (true|false)
     * @var bool
     */
    private $checked      = false;

    /**
     * Placeholder for element
     * @var bool|string
     */
    private $placeholder  = false;

    /**
     * Enable|Disable element
     * @var bool
     */
    private $disabled     = false;

    /**
     * Help description on the bottom of element
     * @var bool|string
     */
    private $help         = false;

    /**
     *
     * @var type 
     */
    private $font_select  = false;

    /**
     * Access types for rendering elements
     * @var array
     */
    private $types        = array();

    /**
     * data
     * 
     * @var type 
     */
    private $data         = array();

    /**
     * text
     * 
     * @var type 
     */
    private $text         = false;

    /**
     *
     * @var type 
     */
    private $custom_value = false;

    /**
     *
     * @var type 
     */
    private $params       = array();

    /**
     *
     * @var type 
     */
    private $hidden       = false;

    /**
     * List form elements
     * @var array
     */
    protected $items       = array();


    public function __construct()
    {
        $this->types = $this->setTypes();
    }

    /**
     * @param $id
     * @param $content
     */
    public function template($id, $content)
    {
        printf( '<script type="text/x-handlebars-template" id="%s">%s</script>', $id, $content );
    }

    /**
     * addItems
     * 
     * @param type $opt
     * @param type $args
     * @param type $set_item
     */
    public function addItems($opt = array(), $args = array(), $set_item = true)
    {
        $foo = array(
            'type'   => 'group',
            'label'  => isset( $opt[ 'label' ] ) ? $opt[ 'label' ] : false,
            'help'   => isset( $opt[ 'help' ] ) ? $opt[ 'help' ] : false,
            'rules'  => $args,
            'values' => array()
        );

        foreach ($this->items as $key => $val) {
            if (isset($val['name']) && isset($args[$val['name']])) {
                $foo['values'][] = $val;
                unset($this->items[$key]);
            }
        }

        $this->items[] = $foo;
    }

    /**
     * Add One item from form (textarea, checkbox, etc. - see setTypes)
     * @param bool|string $type
     * @param array $args if $type is (string) fill parameters
     * @param bool $set_item if $type is (string) and $set_item === true will call $this->setItem() after filling all parameters
     *
     * @return $this
     */
    public function addItem( $type = false, $args = array(), $set_item = true )
    {
        $defaults = array(
            'type'         => false,
            'label'        => false,
            'class'        => false,
            'form_group'   => false,
            'id'           => false,
            'name'         => false,
            'multiple'     => false,
            'value'        => false,
            'values'       => false,
            'placeholder'  => false,
            'disabled'     => false,
            'help'         => false,
            'width'        => false,
            'height'       => false,
            'crop_name'    => false,
            'font_select'  => false,
            'data'         => array(),
            'custom_value' => false,
            'text'         => false,
            'params'       => array(),
            'hidden'       => false
        );

        foreach( $defaults as $key => $val ){
            $this->{$key} = $val;
        }

        if ($type) {
            $this->setType( $type );
            unset($defaults['type']);

            if (count($args)) {
                foreach($defaults as $key => $val) {
                    if (isset($args[$key])) {
                        $this->{$key} = $args[$key];
                    }
                }
            }

            if ($set_item) {
                return $this->setItem();
            }
        }

        return $this;
    }

    /**
     * renderItems
     * 
     * @param type $echo
     * @return string
     */
    public function renderItems($echo = false)
    {
        $content = '';
        if (count($this->items)) {
            $buttons = array(
                'type' => 'buttons',
                'data' => array()
            );

            foreach ($this->items as $key => $val) {
                if ($val['type' ] == 'buttons') {
                    $buttons['data'][] = $val;
                    unset($this->items[$key]);
                }
            }

            $this->items[] = $buttons;
            foreach ($this->items as $key => $val) {
                $content .= $this->item($val['type'], $val) . "\n";
            }
        }

        $this->items = array();

        if (!$echo)
            return $content;

        echo $content;
    }

    /**
     * renderPanel
     * 
     * @param type $args
     * @param type $echo
     * @return type
     */
    public function renderPanel($args = array(), $echo = true)
    {
        if ($args && count($args))
            $this->addPanel($args);

        $foo = array(
            'panel-title-icon'  => $this->panel_title_icon,
            'panel-title'       => $this->panel_title,
            'panel-heading'     => $this->panel_heading,
            'panel-help'        => $this->panel_help,
            'panel-description' => $this->panel_description,
            'panel-class'       => $this->panel_class,
            'panel-content'     => $this->panel_content,
        );

        $content = $this->panel( $foo );

        if (!$echo)
            return $content;

        echo $content;
    }

    /**
     * addPanel
     * 
     * @param type $args
     * @return $this
     */
    public function addPanel($args = array())
    {
        $default = array(
            'panel_title_icon'  => false,
            'panel_title'       => false,
            'panel_heading'     => false,
            'panel_help'        => false,
            'panel_description' => false,
            'panel_class'       => 'default',
            'panel_content'     => '',
        );

        if (count($args)) foreach($default as $key => $val) {
            $this->{$key} = isset($args[$key]) ? $args[$key] : $val;
        } else foreach($default as $key => $val) {
            $this->{$key} = $val;
        }

        return $this;
    }

    /**
     * setPanelTitleIcon
     * 
     * @param type $icon
     * @return $this
     */
    public function setPanelTitleIcon($icon)
    {
        $this->panel_title_icon = $this->parse_quotes($icon);
        return $this;
    }

    /**
     * setPanelTitle
     * 
     * @param type $title
     * @return $this
     */
    public function setPanelTitle($title)
    {
        $this->panel_title = esc_html($title);
        return $this;
    }

    /**
     * setHeading
     * 
     * @param type $element
     * @return $this
     */
    public function setHeading($element)
    {
        $this->panel_heading = esc_html($element);
        return $this;
    }

    /**
     * setPanelDescription
     * 
     * @param type $description
     * @return $this
     */
    public function setPanelDescription($description)
    {
        $this->panel_description = $this->parse_quotes($description);
        return $this;
    }

    /**
     * setPanelClass
     * 
     * @param type $class
     * @return $this
     */
    public function setPanelClass($class)
    {
        $this->panel_class = $this->parse_quotes($class);
        return $this;
    }

    /**
     * setPanelContent
     * 
     * @param type $content
     * @return $this
     */
    public function setPanelContent($content)
    {
        $this->panel_content = $content;
        return $this;
    }

    /**
     * Use after add all parameters through $this->addItem()
     * This method add element into list form elements
     */
    public function setItem()
    {
        $defaults = array(
            'type'         => false,
            'label'        => false,
            'checked'      => false,
            'class'        => false,
            'form_group'   => false,
            'id'           => false,
            'name'         => false,
            'multiple'     => false,
            'value'        => false,
            'values'       => false,
            'placeholder'  => false,
            'disabled'     => false,
            'help'         => false,
            'width'        => false,
            'height'       => false,
            'crop_name'    => false,
            'font_select'  => false,
            'data'         => array(),
            'text'         => false,
            'custom_value' => false,
            'params'       => array(),
            'hidden'       => false
        );

        $foo = array();

        foreach ($defaults as $key => $val)
        {
            $foo[$key] = $this->{$key};
        }

        $this->items[] = $foo;
        return $this;
    }

    /**
     * setType
     * 
     * @param type $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = false;
        if (in_array($type, $this->types))
            $this->type = $type;

        return $this;
    }

    /**
     * setLabel
     * 
     * @param type $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = esc_html(strip_tags($label));
        return $this;
    }

    /**
     * 
     * @param type $class
     * @return $this
     */
    public function setClass($class = '')
    {
        $this->class = $this->parse_quotes($class);
        return $this;
    }

    /**
     * setFormGroup
     * 
     * @param type $group
     * @return $this
     */
    public function setFormGroup($group = false)
    {
        $this->form_group = $group ?:false;
        return $this;
    }

    /**
     * setId
     * 
     * @param type $id
     * @return $this
     */
    public function setId($id = '')
    {
        $this->id = $this->parse_quotes($id);
        return $this;
    }

    /**
     * setName
     * 
     * @param type $name
     * @return $this
     */
    public function setName($name = '')
    {
        $this->name = $this->parse_quotes($name);
        return $this;
    }

    /**
     * setValue
     * 
     * @param type $value
     * @return $this
     */
    public function setValue($value = '')
    {
        $this->value = $this->parse_quotes($value);
        return $this;
    }

    /**
     * setValues
     * 
     * @param type $values
     * @return $this
     */
    public function setValues($values = '')
    {
        if (is_array($values)) {
            $foo = array();
            foreach($values as $key => $val)
                $foo[$key] = $this->parse_quotes($val);

            $values = $foo;
        }

        $this->values = $this->parse_quotes($values) ;
        return $this;
    }

    /**
     * setChecked
     * 
     * @param type $checked
     * @return $this
     */
    public function setChecked($checked = '')
    {
        $this->checked = $checked ?: false;
        return $this;
    }

    /**
     * setMultiple
     * 
     * @param type $multiple
     * @return $this
     */
    public function setMultiple($multiple = '')
    {
        $this->multiple = $multiple ?: false;
        return $this;
    }

    /**
     * setPlaceholder
     * 
     * @param type $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder = '')
    {
        $this->placeholder = $this->parse_quotes($placeholder);
        return $this;
    }

    /**
     * setDisabled
     * 
     * @param type $disabled
     * @return $this
     */
    public function setDisabled($disabled = '')
    {
        $this->disabled = $disabled ?: false;
        return $this;
    }

    /**
     * setHelp
     * 
     * @param type $help
     * @return $this
     */
    public function setHelp($help = '')
    {
        $this->help = $this->parse_quotes($help);
        return $this;
    }

    /**
     * setData
     * 
     * @param type $data
     */
    public function setData($data = array())
    {
        $this->data = $data;
    }

    /**
     * setText
     * 
     * @param type $text
     */
    public function setText($text = '')
    {
        $this->text = $text;
    }

    /**
     * 
     * @param type $custom_value
     */
    public function setCustomValue($custom_value)
    {
        $this->custom_value = $custom_value;
    }

    /**
     * setTypes
     * 
     * @return type
     */
    protected function setTypes()
    {
        return array(
            'text', 'button'
        );
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    protected function parse_quotes($str)
    {
        return str_replace(array('"', "'"), '', strip_tags($str));
    }
}