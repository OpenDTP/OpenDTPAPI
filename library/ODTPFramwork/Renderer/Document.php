<?php

/**
 * A document object for renderers
 */
class ODTPFramwork_Renderer_Document extends ODTPFramwork_Renderer_Document_Abstract
{
    protected $_renderer;

    public function init($file)
    {
        parent::init($file);
        if (!file_exists($file)) {
            throw new ODTPFramwork_Renderer_Document_Exception("$file not found");
        }
        $infos = pathinfo($file);
        $this->setName($infos['filename']);
        $this->setFile($infos['basename']);
        $this->setPath($infos['dirname']);
        $this->setExtension($infos['extension']);
    }

    /**
     * Getters and setters
     */

    /**
     * Return the renderer type
     *
     * @return string the renderer type
     */
    public function getRenderer()
    {
        return $this->_renderer;
    }

    /**
     * Set the renderer type
     *
     * @param string $renderer The renderer type matching this document (Scribus, InDesign, etc ...)
     *
     * @throws ODTPFramwork_Renderer_Document_Exception If $renderer is not a string
     * @return null
     */
    public function setRenderer($renderer)
    {
        if (!is_string($renderer)) {
            throw new ODTPFramwork_Renderer_Document_Exception('$renderer must be a string');
        }
        $this->_renderer = $renderer;
    }

}
