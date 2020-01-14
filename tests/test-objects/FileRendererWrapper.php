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
        $f_name='', array $data=array(), array $f_paths=array(), $esc_enc='utf-8', 
        array $h_esc_keys=array(), array $h_att_esc_keys=array(), array $css_esc_keys=array(), $js_esc_keys=array()
    ) {
        parent::__construct(
            $f_name, $data, $f_paths, $esc_enc, $h_esc_keys, $h_att_esc_keys, $css_esc_keys, $js_esc_keys
        );
    }
    
    public function escapeDataPublic(
        array &$data, $esc_enc='utf-8', array $h_esc_keys=array(), array $h_att_esc_keys=array(), 
        array $css_esc_keys=array(), array $js_esc_keys=array(), \Laminas\Escaper\Escaper $esc=null
    ) {
        parent::escapeData(
            $data, $esc_enc, $h_esc_keys, $h_att_esc_keys,  $css_esc_keys, $js_esc_keys, $esc
        );
    }
    
    public function normalizeFolderPathPublic($f_path) { return parent::normalizeFolderPath($f_path); }
    
    public function getVarTypePublic($var, $cap_1st=false) { return parent::getVarType($var, $cap_1st); }
}