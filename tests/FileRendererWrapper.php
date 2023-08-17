<?php
namespace Rotexsoft\FileRenderer\Tests;
/**
 * Class for exposing protected & private methods in \Rotexsoft\FileRenderer\Renderer for testing.
 *
 * @author Rotimi Adegbamigbe
 */
class FileRendererWrapper extends \Rotexsoft\FileRenderer\Renderer
{
    public function __construct(
        $f_name='', array $data=[], array $f_paths=[], $esc_enc='utf-8', 
        array $h_esc_keys=[], array $h_att_esc_keys=[], array $css_esc_keys=[], $js_esc_keys=[]
    ) {
        parent::__construct(
            $f_name, $data, $f_paths, $esc_enc, $h_esc_keys, $h_att_esc_keys, $css_esc_keys, $js_esc_keys
        );
    }
    
    public function escapeDataPublic(
        array &$data, $esc_enc='utf-8', array $h_esc_keys=[], array $h_att_esc_keys=[], 
        array $css_esc_keys=[], array $js_esc_keys=[], \Laminas\Escaper\Escaper $esc=null
    ) {
        parent::escapeData(
            $data, $esc_enc, $h_esc_keys, $h_att_esc_keys,  $css_esc_keys, $js_esc_keys, $esc
        );
    }
    
    public function normalizeFolderPathPublic($f_path) { return parent::normalizeFolderPath($f_path); }
    
    public function doRenderPublic(string $file_to_include, array $data) {
        return parent::doRender($file_to_include, $data);
    }

    public function getEscapeEncoding():string {
        
        return $this->escape_encoding;
    }
    
    public function setEscapeEncoding($escape_encoding):self {
        
        $this->escape_encoding = $escape_encoding;
        
        return $this;
    }
}
