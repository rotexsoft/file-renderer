<?php
namespace Rotexsoft;

/**
 * 
 * Class for rendering the contents of a php file.
 *
 * @author Rotimi Adegbamigbe
 * 
 */
class Renderer
{
    /**
     * 
     * Path(s) to directorie(s) containing (*.php) files to be rendered via this 
     * class. 
     * 
     * These paths will be searched when rendering a file with an instance of 
     * this class.
     *
     * @var string|array
     *  
     */
    protected $file_paths;

    /**
     *
     * Name of php a file to be rendered. 
     * 
     * If path is not prepended to the name of the file, the file will be 
     * searched for in the list of paths registered in $this->file_paths.
     * 
     * It could be left blank (which means that a file name must supplied when
     * calling any of the render* methods).
     * 
     * @var string 
     * 
     */
    protected $file_name;
    
    /**
     * 
     * An array of data to be extracted into variables for use in the php file 
     * to be rendered via an instance of this class.
     *
     * @var array  
     *             
     */
    protected $data;

    /**
     * 
     * @param string $file_name name of a php file to be rendered. If path is not 
     *                          prepended to the name of the file, the file will 
     *                          be searched for in the list of paths registered 
     *                          in $this->file_paths. It can be 
     *                          left blank.
     * 
     * @param array $data An array of data to be extracted into variables for 
     *                    use in the php fileto be rendered via an instance of 
     *                    this class.
     * 
     * @param array $file_paths An array of path(s) to directorie(s) containing 
     *                          (*.php) files to be rendered via this class.
     * 
     * @throws \InvalidArgumentException
     */
    public function __construct($file_name='', array $data = array(), array $file_paths = array() ) {
        
        if( !is_string($file_name) ) {
            
            $msg = "ERROR: ". get_class($this) ."::__construct(...) expects first parameter (the name of the php file to be rendered) to be a `string`." 
                   . PHP_EOL .'`'. $this->getVarType($file_name, true).'` was supplied with the value below:'
                   . PHP_EOL . var_export($file_name, true). PHP_EOL ;
            
            throw new \InvalidArgumentException($msg);
        }
        
        $this->data = $data;
        $this->file_name = $file_name;
        $this->file_paths = $file_paths;
    }
    
    public function __set($name, $value) {
        
        $this->data[$name] = $value;
    }

    public function __get($name) {
        
        if ( isset($this->data[$name]) ) {

            return $this->data[$name];
            
        } else {

            $msg = "ERROR: Item with key '$name' does not exist in " 
                   . get_class($this) .'.'. PHP_EOL . $this->__toString();
            
            throw new \Exception($msg);
        }
    }
    
    public function __isset($name) {
        
        return isset($this->data[$name]);
    }
    
    public function __unset($name) {
        
        unset($this->data[$name]);
    }
    
    public function setVar($name, $value) {
        
        $this->__set($name, $value);
    }
    
    public function getVar($name) {
        
        return $this->__get($name);
    }

    /**
     * 
     * Returns the value of the `file_paths` property of an instance
     * of this class.
     * 
     * @return array the array of path(s) to directorie(s) containing (*.php) 
     *               files to be rendered via this class.
     * 
     */
    public function getFilePaths() {
        
        return $this->file_paths;
    }
    
    /**
     * 
     * Add a path to the end of the array of path(s) to directorie(s) containing 
     * (*.php) files to be rendered via this class.
     * 
     * @param string $path
     * 
     */
    public function appendPath( $path ) {
        
        $this->file_paths[] = $path;
    }

    /**
     * 
     * Add a path to the beginning of the array of path(s) to directorie(s) 
     * containing (*.php) files to be rendered via this class.
     * 
     * @param string $path
     * 
     */
    public function prependPath( $path ) {
        
        array_unshift($this->file_paths, $path);
    }
    
    /**
     * 
     * Removes the first `n` elements in the array of path(s) to directorie(s) 
     * containing (*.php) files to be rendered via this class.
     * 
     * @param string $number_of_paths_2_remove
     * 
     */
    public function removeFirstNPaths($number_of_paths_2_remove) {
        
        if( is_numeric($number_of_paths_2_remove) ) {
            
            while ( 
                $number_of_paths_2_remove > 0  
                && count($this->file_paths) > 0 
            ) {
                array_shift($this->file_paths);
                $number_of_paths_2_remove--;
            }
        }
    }
    
    /**
     * 
     * Removes the last `n` elements in the array of path(s) to directorie(s) 
     * containing (*.php) files to be rendered via this class.
     * 
     * @param string $number_of_paths_2_remove
     * 
     */
    public function removeLastNPaths($number_of_paths_2_remove) {
        
        if( is_numeric($number_of_paths_2_remove) ) {
            
            while ( 
                $number_of_paths_2_remove > 0  
                && count($this->file_paths) > 0 
            ) {
                array_pop($this->file_paths);
                $number_of_paths_2_remove--;
            }
        }
    }
    
    /**
     * 
	 * Captures and returns the output that is generated when a php file is included. 
     * 
     * @param string $file_name Name of php file to be included (with/without
     *                          the directory path). If the directory path is 
     *                          included & the file exists, it is included and
     *                          the output is returned. If the directory path is 
     *                          not included, the file will be searched for from 
     *                          the list of directories registered in 
     *                          $this->file_paths.
     *                          
     *                          If $file_name still can't be found or is an empty 
     *                          string or is not supplied, this method tries to 
     *                          locate $this->file_name if possible and renders 
     *                          it instead.
     *                          
     * @param array $data Array of data to be extracted to make local variables.
     *                    It is combined together with $this->data. It will
     *                    overwrite item(s) with the same key in $this->data.
     * 
     * @return string the output that is generated when $file_name or $this->file_name is included
     * 
     * @throws \Slim3Mvc\FileNotFoundException
     * 
     */
    public function renderToString( $file_name='', array $data = array() ) {

        if( !is_string($file_name) ) {
            
            $msg = "ERROR: ". get_class($this) ."::".__FUNCTION__."(..) expects"
                 . " first parameter (the name of the php file to be rendered) to be a `string`." 
                 . PHP_EOL .'`'. $this->getVarType($file_name, true).'` was supplied with the value below:'
                 . PHP_EOL . var_export($file_name, true). PHP_EOL ;
            
            throw new \InvalidArgumentException($msg);
        }
        
        $located_file = $this->locateFile($file_name);
        
        if( $located_file === false ) {
            
            //File name supplied to this method was not found. 
            //Try to see if the file name supplied when this 
            //class was instantiated can be found.
            $located_file = $this->locateFile($this->file_name);
        }
        
        if( $located_file === false ) {
            
            //The file does not exist in any of the registered possible paths
            $msg = "ERROR: Could not load the file named `$file_name` "
                . "from any of the paths below:"
                . PHP_EOL . implode(PHP_EOL, $this->file_paths) . PHP_EOL
                . PHP_EOL . get_class($this) . '::' . __FUNCTION__ . '(...).' 
                . PHP_EOL;
            
            throw new FileNotFoundException($msg);
        }
        
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
        ////
        //// Deliberately not specifying parameters in the anonymous function's 
        //// definition signature below in order to avoid having any explicit 
        //// variable(s) defined inside the anonymous function. Rather, the 
        //// parameters are being accessed via func_get_arg() and not even 
        //// assigned to any local variable(s) inside the function.
        ////
        //// This way we need not worry about any variable(s) being overwritten
        //// inside the anonymous function when extract(..) is called within the 
        //// anonymous function.
        ////  
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
        $render_view = function()
        {
            //func_get_arg(0): the name of the file to be included whose output 
            //                 is to be captured and returned

            //func_get_arg(1): the data array from which to extract variables

            //Extract variables from the data array which may be needed in the
            //view file to be included below.
            extract(func_get_arg(1));

            // Capture the view output
            ob_start();

            // Load the view within the current scope
            include func_get_arg(0);

            // Get the captured output and close the buffer
            return ob_get_clean();
        };
        
        return $render_view($located_file, array_merge($this->data, $data));
    }
    
    /**
     * 
     * Captures and prints out the output that is generated when a php file is included. 
     * 
     * @param string $file_name Name of php file to be included (with/without
     *                          the directory path). If the directory path is 
     *                          included & the file exists, it is included and
     *                          the output is returned. If the directory path is 
     *                          not included, the file will be searched for from 
     *                          the list of directories registered in 
     *                          $this->file_paths.
     *                          
     *                          If $file_name still can't be found or is an empty 
     *                          string or is not supplied, this method tries to 
     *                          locate $this->file_name if possible and renders 
     *                          it instead.
     *                          
     * @param array $data Array of data to be extracted to make local variables.
     *                    It is combined together with $this->data. It will
     *                    overwrite item(s) with the same key in $this->data.
     * 
     * @return void
     * 
     * @throws \Slim3Mvc\FileNotFoundException
     * 
     */
    public function renderToScreen($file_name, array $data = array()) {
        
        echo $this->renderToString($file_name, $data);
    }
    
    /**
     * 
     * @param string $file_name Name of file (with / without the directory path) 
     *                          to be located in the registered possible paths 
     *                          ($this->file_paths).
     * 
     * @return boolean|string If the directory path is included in $file_name 
     *                        & the file exists, this method returns $file_name.
     * 
     *                        Else it searches for $file_name within the 
     *                        directories registered in $this->file_paths and 
     *                        returns $file_name prepended with the first directory 
     *                        name in $this->file_paths in which $file_name exists.
     * 
     *                        Finally, if $file_name cannot be found in any of 
     *                        the registered paths, false is returned.
     * 
     * @throws \InvalidArgumentException
     * 
     */
    public function locateFile($file_name) {
        
        if( !is_string($file_name) ) {
                        
            $msg = "ERROR: ". get_class($this) ."::".__FUNCTION__."(...) expects first parameter (the name of the php file to be located) to be a `string`." 
                   . PHP_EOL .'`'. $this->getVarType($file_name, true).'` was supplied with the value below:'
                   . PHP_EOL . var_export($file_name, true). PHP_EOL ;
            
            throw new \InvalidArgumentException($msg);
        }
        
        $ds = DIRECTORY_SEPARATOR;
        
        //Check to see if a path was prepended to the file name
        $file_name_contains_path = 
                            strlen( basename($file_name) ) < strlen($file_name);

        //Check if file actually exists as is (if a path was prepended to it).
        $located_file = 
            ( 
                !empty($file_name) && file_exists($file_name) 
                && is_file($file_name) && $file_name_contains_path 
            ) ? $file_name : false;
        
        if(  $located_file === false && !empty($file_name) ) {
            
            //$file_name is not an existent file on its own. 
            //Search for it in the list of paths registered in $this->file_paths.
            foreach ( $this->file_paths as $possible_path ) {

                $potential_file =  
                    rtrim($possible_path, $ds) . $ds . $file_name;

                if( file_exists($potential_file) && is_file($potential_file) ) {

                    //found the file
                    $located_file = rtrim($possible_path, $ds) . $ds . $file_name;
                    break;
                }
            }
        }
        
        //file not found
        return $located_file;
    }
    
    /**
     * 
     * An enhancement to PHP's gettype function that displays the class name of a variable if the variable is an object.
     * 
     * @param mixed $var a variable whose type is to be determined
     * @param bool $cap_first flag to indicate if the variable's type should be returned with the first letter in uppercase
     * 
     * @return string the variable's type
     * 
     */
    protected function getVarType($var, $cap_first=false) {

        if( is_object($var) ) {

            return $cap_first ? ucfirst(get_class($var)) : get_class($var);
        }

        return $cap_first ? ucfirst(gettype($var)) : gettype($var);
    }
}

class FileNotFoundException extends \Exception { }