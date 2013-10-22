<?php

/**
 * Interface for renderer query object
 */
interface ODTPFramwork_Renderer_Query_Interface
{
    public function input($src);
    public function output($src);
    public function action($params);
}