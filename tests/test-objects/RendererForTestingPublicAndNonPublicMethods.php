<?php

/**
 * 
 * Description of RecordForTestingPublicAndProtectedMethods
 *
 * @author aadegbam
 */
class RendererForTestingPublicAndNonPublicMethods extends \Rotexsoft\FileRenderer\Renderer
{
    public function __construct(
        $file_name = '', $data = array(), array $file_paths = array()
    ) {
        parent::__construct($file_name, $data, $file_paths);
    }
}