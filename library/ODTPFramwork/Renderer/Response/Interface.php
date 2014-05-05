<?php

/**
 * Interface for renderer response object
 */
interface ODTPFramwork_Renderer_Response_Interface
{
    /**
     * Return the HTTP response code
     *
     * @return int The HTTP response code
     */
    public function getCode();

    /**
     * Return the response depending on the given format
     *
     * @param string $format The format of response
     *
     * @return mixed The response parsed depending on $format
     */
    public function getResponse($format = null);
}
