<?php

/**
 * Simple query parser for ODTPFramwork Renderer Query objects
 */
class ODTPFramwork_Renderer_Query_Parser
{
    protected $_keywords
        = array(
            'render', 'deconstruct', 'info', 'input', 'output', 'type', 'page', 'scale'
        );

    /**
     * Preprocess string to have keywords separated from parameters by space
     *
     * @param  string $query Query to preprocess
     *
     * @return array
     */
    protected function preprocessQuery($query)
    {
        return preg_replace('#[\s]*([,=])[\s]*#', '$1', $query);
    }

    /**
     * parses the provided command
     *
     * @TODO Need to change some things to handle UPDATE and INFO queries
     *
     * @param string $query The query string to parse
     *
     * @return array parsed query
     */
    public function parseString($query)
    {
        if (!is_string($query)) {
            throw new ODTPFramwork_Renderer_Query_Exception('$query must be a string');
        }
        $parsed_query = array();

        // First, we prepare the query, keywords and parameters are now space separate
        $formated_query = $this->preprocessQuery($query);
        $parameters = explode(' ', $formated_query);
        $current_keyword = null;
        foreach ($parameters as $parameter) {
            $lower_parameter = strtolower($parameter);

            // It's a parameter, but no keyword before it
            if (!in_array($lower_parameter, $this->_keywords) && is_null($current_keyword)) {
                throw new ODTPFramwork_Renderer_Query_Exception("Parse error in query : $query --- Near : $parameter");

                // We found a keyword
            } else {
                if (in_array($lower_parameter, $this->_keywords)) {
                    if (!isset($parsed_query[$current_keyword])) {
                        $parsed_query[$current_keyword] = array();
                    }
                    $current_keyword = $lower_parameter;

                    // It's a parameter. If keywords already set we throw an exception.
                } else {
                    if (isset($parsed_query[$current_keyword])) {
                        throw new ODTPFramwork_Renderer_Query_Exception("Parse error in query : $query --- Near : $parameter");
                    }
                    $parsed_query[$current_keyword] = explode(',', $parameter);
                    $current_keyword = null;
                }
            }
        }

        return $parsed_query;
    }
}
