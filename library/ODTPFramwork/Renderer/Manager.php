<?php

/**
 * Connection manager for renderers
 */
class ODTPFramwork_Renderer_Manager extends ODTPFramwork_Renderer_Manager_Abstract
{
    public function init($parameters)
    {
        parent::init($parameters);
    }

    /**
     * Send a query to renderers in pool and return an array of response.
     *
     * @param  ODTPFramwork_Renderer_Query_Interface $query The query to send.
     *
     * @throws ODTPFramwork_Renderer_Manager_Exception If No renderer is available
     * @return array    Array of ODTPFramwork_Renderer_Query_Interface
     */
    public function query(ODTPFramwork_Renderer_Query_Interface $query)
    {

        // @TODO : type matching must be defined in ini configutarion file
        // Set up document manager to match and sync documents
        $manager = new ODTPFramwork_Renderer_Document_Manager($query->getInput(), array('scribus' => array('sla')));
        $responses = array();

        // Query is send by renderer type.
        foreach ($manager->getDocuments() as $renderer => $documents) {
            $has_renderer_available = false;

            // Retrieve the list of plugins and try them by fallback
            foreach ($this->getPlugins($renderer) as $plugin) {
                try {
                    $responses[] = $plugin->query($query);
                    $has_renderer_available = true;
                    break;
                } catch (ODTPFramwork_Renderer_Exception $e) {
                    //@TODO define error codes to know if there's an error
                }
            }
            if (!$has_renderer_available) {
                throw new ODTPFramwork_Renderer_Manager_Exception("No renderer $renderer available");
            }
        }

        return $responses;
    }
}
