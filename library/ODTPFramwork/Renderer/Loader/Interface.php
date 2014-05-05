<?php

/**
 * Interface for Renderer loader
 */
interface ODTPFramwork_Renderer_Loader_Interface
{
    public function getRenderer($name);

    public function getRenderers();
}
