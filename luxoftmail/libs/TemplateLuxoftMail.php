<?php

/**
 * Description of TemplateLuxoftMail
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:32:22 AM
 */
class TemplateLuxoftMail
{	

    /**
     *
     * @var type 
     */
    public $args = array();

    /**
     *
     * @var type 
     */
    public $view = array();

    /**
     *
     * @var type 
     */
    private $_templatePath = 'templates';

    /**
     *
     * @var type 
     */
    private $_layoutPath = 'layout';

    /**
     *
     * @var type 
     */
    private $_layout = 'layout';

    /**
     * 
     * @param type $args
     */
    public function __construct($args = array())
    {
        $this->setArgs($args);
    }

    /**
     * render
     */
    public function render($templateName)
    {
        $file = LUXOFTMAIL_PATH . 'libs/' . $this->_templatePath . '/' . '_' . $templateName . '.php';
        if (file_exists($file)) {
            ob_start();
            extract($this->getArgs(), EXTR_SKIP);
            require_once($file);
            $text = ob_get_contents();
            ob_end_clean();
            return $this->renderLayout($text);
        }

        return '';
    }

    /**
     * renderLayout
     * 
     * @param type $content
     * @return string
     */
    public function renderLayout($content)
    {
        $file = LUXOFTMAIL_PATH . 'libs/' . $this->getLayoutPath() . '/' . '_' . $this->getLayout() . '.php';

        if (file_exists($file)) {
            ob_start();
            extract($this->getView(), EXTR_SKIP);
            require_once($file);
            $content = ob_get_clean();
            return $content;
        }

        return '';
    }

    /**
     * getTemplatePath
     * 
     * @return type
     */
    public function getTemplatePath()
    {
        return $this->_templatePath;
    }

    /**
     * getLayout
     * 
     * @return type
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    /**
     * setTemplatePath
     * 
     * @param type $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->_templatePath = $templatePath;
    }

    /**
     * setLayout
     * 
     * @param type $layout
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    /**
     * getArgs
     * 
     * @return type
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * setArgs
     * 
     * @param type $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     * getView
     * 
     * @return type
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * setView
     * 
     * @param type $view
     */
    public function setView($view = array())
    {
        $this->view = $view;
    }

    /**
     * getLayoutPath
     * 
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->_layoutPath;
    }

    /**
     * setLayoutPath
     * 
     * @param type $layoutPath
     */
    public function setLayoutPath($layoutPath)
    {
        $this->_layoutPath = $layoutPath;
    }
}