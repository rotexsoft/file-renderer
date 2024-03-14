<?php
use Rotexsoft\FileRenderer\Tests\FileRendererWrapper;

/**
 * Description of ModelTest
 *
 * @author Rotimi Adegbamigbe
 */
class RendererTest extends \PHPUnit\Framework\TestCase
{
    /**
     * A value between 0 & 3 see \Rotexsoft\FileRenderer::hash_algos() in ./tests/bootstrap.php
     */
    public static int $hash_algo_index = 0;


    protected function setUp(): void { 
        
        parent::setUp();
        
        if(static::$hash_algo_index === 4) {
            
            static::$hash_algo_index = 0;
        }
    }
    
    protected function tearDown(): void {
        
        parent::tearDown();
        static::$hash_algo_index++;
    }

    public function testThatConstructorWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $expected_file_paths = ['/a'];
        $expected_escape_encoding = 'utf-8';
        $expected_js_escaper_keys = ['a'];
        $expected_css_escaper_keys = ['b'];
        $expected_html_escaper_keys = ['c'];
        $expected_html_attr_escaper_keys = ['d'];
        
        $renderer = new FileRendererWrapper(
                            $expected_file_name, 
                            $expected_data, 
                            $expected_file_paths, 
                            $expected_escape_encoding, 
                            $expected_html_escaper_keys, 
                            $expected_html_attr_escaper_keys, 
                            $expected_css_escaper_keys, 
                            $expected_js_escaper_keys
                        );
        $reflection_class = new ReflectionClass($renderer);
        
        //make protected properties accessible via reflection
        $file_name_in_obj = $reflection_class->getProperty('file_name');
        $file_name_in_obj->setAccessible(true);
        
        $data_in_obj = $reflection_class->getProperty('data');
        $data_in_obj->setAccessible(true);
        
        $file_paths_in_obj = $reflection_class->getProperty('file_paths'); 
        $file_paths_in_obj->setAccessible(true); 
        
        $escape_encoding_in_obj = $reflection_class->getProperty('escape_encoding'); 
        $escape_encoding_in_obj->setAccessible(true); 
        
        $html_escaper_keys_in_obj = $reflection_class->getProperty('data_vars_2_html_escape');
        $html_escaper_keys_in_obj->setAccessible(true);
        
        $html_attr_escaper_keys_in_obj = $reflection_class->getProperty('data_vars_2_html_attr_escape');
        $html_attr_escaper_keys_in_obj->setAccessible(true);
        
        $css_escaper_keys_in_obj = $reflection_class->getProperty('data_vars_2_css_escape');
        $css_escaper_keys_in_obj->setAccessible(true);
        
        $js_escaper_keys_in_obj = $reflection_class->getProperty('data_vars_2_js_escape');
        $js_escaper_keys_in_obj->setAccessible(true);
        
        // test with all params supplied; no default vals
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals($expected_escape_encoding, $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_escaper_keys, $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_attr_escaper_keys, $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_css_escaper_keys, $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_js_escaper_keys, $js_escaper_keys_in_obj->getValue($renderer));
        
        //test default vals
        $renderer = new FileRendererWrapper($expected_file_name);
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals([], $data_in_obj->getValue($renderer));
        $this->assertEquals([], $file_paths_in_obj->getValue($renderer));
        $this->assertEquals('utf-8', $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals([], $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data);
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals([], $file_paths_in_obj->getValue($renderer));
        $this->assertEquals('utf-8', $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals([], $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $expected_file_paths);
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals('utf-8', $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals([], $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper(
                            $expected_file_name, 
                            $expected_data, 
                            $expected_file_paths, 
                            $expected_escape_encoding
                        );
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals($expected_escape_encoding, $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals([], $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper(
                            $expected_file_name, 
                            $expected_data, 
                            $expected_file_paths, 
                            $expected_escape_encoding, 
                            $expected_html_escaper_keys
                        );
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals($expected_escape_encoding, $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_escaper_keys, $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper(
                            $expected_file_name, 
                            $expected_data, 
                            $expected_file_paths, 
                            $expected_escape_encoding, 
                            $expected_html_escaper_keys, 
                            $expected_html_attr_escaper_keys
                        );
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals($expected_escape_encoding, $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_escaper_keys, $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_attr_escaper_keys, $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
        
        $renderer = new FileRendererWrapper(
                            $expected_file_name, 
                            $expected_data, 
                            $expected_file_paths, 
                            $expected_escape_encoding, 
                            $expected_html_escaper_keys, 
                            $expected_html_attr_escaper_keys, 
                            $expected_css_escaper_keys
                        );
        $this->assertEquals($expected_file_name, $file_name_in_obj->getValue($renderer));
        $this->assertEquals($expected_data, $data_in_obj->getValue($renderer));
        $this->assertEquals($expected_file_paths, $file_paths_in_obj->getValue($renderer));
        $this->assertEquals($expected_escape_encoding, $escape_encoding_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_escaper_keys, $html_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_html_attr_escaper_keys, $html_attr_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals($expected_css_escaper_keys, $css_escaper_keys_in_obj->getValue($renderer));
        $this->assertEquals([], $js_escaper_keys_in_obj->getValue($renderer));
    }

    public function testThat__setWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt');
        $renderer->__set('key1', 'val1'); //set via explicit call
        $renderer->key2 = 'val2';         //set via assignment to non-existent object property which 
                                          //will internally trigger $renderer->__set('key2', 'val2');
        
        //make protected `data` property accessible via reflection
        $reflection_class = new ReflectionClass($renderer);        
        $data_in_obj = $reflection_class->getProperty('data');
        $data_in_obj->setAccessible(true);
        $data_array_in_obj = $data_in_obj->getValue($renderer);
        
        $this->assertEquals('val1', $data_array_in_obj['key1']);
        $this->assertEquals('val2', $data_array_in_obj['key2']);
    }

    public function testThatSetVarWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt');
        static::assertSame($renderer, $renderer->setVar('key1', 'val1')); //set via explicit call
        static::assertSame($renderer, $renderer->setVar('key2', 'val2')); //set via explicit call
        
        //make protected `data` property accessible via reflection
        $reflection_class = new ReflectionClass($renderer);        
        $data_in_obj = $reflection_class->getProperty('data');
        $data_in_obj->setAccessible(true);
        $data_array_in_obj = $data_in_obj->getValue($renderer);
        
        $this->assertEquals('val1', $data_array_in_obj['key1']);
        $this->assertEquals('val2', $data_array_in_obj['key2']);
    }
    
    public function testExceptionMessageWhenNonExistentPropertyThatsNeverBeenSetIsAccessed() {
        
        $expected_msg = "ERROR: Item with key 'key1' does not exist in ";
        $renderer = new FileRendererWrapper('file.txt');
        
        try {
            $renderer->__get('key1'); //explicit call to a property that isn't defined & hasn't been set
            
            //if the call to __get above did not throw an exception, then this test should fail
            $message = __FUNCTION__. '() : Expected exception not thrown when accessing non'
                                   . ' existent property.';
            throw new \Exception($message);
            
        } catch (\Exception $e) {
            
            //echo PHP_EOL.$e->getMessage().PHP_EOL.'yoooo'.PHP_EOL;
            $this->assertStringContainsString($expected_msg, $e->getMessage());
            
            try {
                $renderer->key1; //Object access to a property that isn't defined & hasn't been set
                                 //will internally trigger $renderer->__get('key1')

                //if the statement above ($renderer->key1) did not throw an exception, 
                //then this test should fail
                $message = __FUNCTION__. '() : Expected exception not thrown when accessing non'
                                       . ' existent property.';
                throw new \Exception($message);

            } catch (\Exception $e) {

                //echo PHP_EOL.$e->getMessage().PHP_EOL.'yoooo'.PHP_EOL;
                $this->assertStringContainsString($expected_msg, $e->getMessage());
            }
        }
    }
    
    public function testThat__getWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt', ['key1'=>'val1', 'key2'=>'val2']);
        
        $this->assertEquals('val1', $renderer->__get('key1'));
        $this->assertEquals('val2', $renderer->__get('key2'));
        $this->assertEquals('val1', $renderer->key1);
        $this->assertEquals('val2', $renderer->key2);
    }
    
    public function testThatGetVarWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt', ['key1'=>'val1', 'key2'=>'val2']);
        
        $this->assertEquals('val1', $renderer->getVar('key1'));
        $this->assertEquals('val2', $renderer->getVar('key2'));
    }
    
    public function testThat__issetWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt', ['key1'=>'val1', 'key2'=>'val2']);
        
        $this->assertEquals(true, $renderer->__isset('key1'));
        $this->assertEquals(true, $renderer->__isset('key2'));
        $this->assertEquals(false, $renderer->__isset('non_existent_property'));
    }
    
    public function testThat__unsetWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt', ['key1'=>'val1', 'key2'=>'val2']);
        
        $this->assertEquals(true, $renderer->__isset('key1'));
        $renderer->__unset('key1');
        $this->assertEquals(false, $renderer->__isset('key1'));
        
        $this->assertEquals(true, $renderer->__isset('key2'));
        $renderer->__unset('key2');
        $this->assertEquals(false, $renderer->__isset('key2'));
        
    }
    
    public function testThatGetDataWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $expected_file_paths = ['/a'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $expected_file_paths);
        $this->assertEquals($expected_data, $renderer->getData());        
    }
    
    public function testThatGetFilePathsWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $expected_file_paths = ['/a'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $expected_file_paths);
        $this->assertEquals($expected_file_paths, $renderer->getFilePaths());        
    }
    
    public function testThatAppendPathWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $original_file_paths = ['/a'];
        $expected_file_paths = ['/a', '/b'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $original_file_paths);
        static::assertSame($renderer, $renderer->appendPath('/b'));
        $this->assertEquals($expected_file_paths, $renderer->getFilePaths());        
    }
    
    public function testThatPrependPathWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $original_file_paths = ['/b'];
        $expected_file_paths = ['/a', '/b'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $original_file_paths);
        static::assertSame($renderer, $renderer->prependPath('/a'));
        $this->assertEquals($expected_file_paths, $renderer->getFilePaths());        
    }
    
    public function testThatHasPathWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $original_file_paths = ['/b'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $original_file_paths);
        static::assertSame($renderer, $renderer->prependPath('/a'));
        static::assertSame($renderer, $renderer->appendPath('/c'));
        $this->assertEquals( $renderer->hasPath('/a'), true);
        $this->assertEquals( $renderer->hasPath('/b'), true);
        $this->assertEquals( $renderer->hasPath('/c'), true);
    }
    
    public function testThatRemoveFirstNPathsWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $original_file_paths = ['/a', '/b', '/c', '/d', '/e', '/f', '/g'];
        $expected_file_paths1 = ['/b', '/c', '/d', '/e', '/f', '/g'];
        $expected_file_paths2 = ['/g'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $original_file_paths);
        
        $this->assertEquals($original_file_paths, $renderer->getFilePaths());
        
        $removed_paths = $renderer->removeFirstNPaths(1);
        $this->assertEquals($expected_file_paths1, $renderer->getFilePaths());
        $this->assertEquals(array_slice($original_file_paths, 0, 1), $removed_paths);
        
        $removed_paths = $renderer->removeFirstNPaths(5);
        $this->assertEquals($expected_file_paths2, $renderer->getFilePaths());
        $this->assertEquals(array_slice($original_file_paths, 1, 5), $removed_paths);
    }
    
    public function testThatRemoveLastNPathsWorksAsExpected() {
        
        $expected_file_name = 'fizaile';
        $expected_data = ['a'=>'b'];
        $original_file_paths = ['/a', '/b', '/c', '/d', '/e', '/f', '/g'];
        $expected_file_paths1 = ['/a', '/b', '/c', '/d', '/e', '/f'];
        $expected_file_paths2 = ['/a'];
        
        $renderer = new FileRendererWrapper($expected_file_name, $expected_data, $original_file_paths);
        
        $this->assertEquals($original_file_paths, $renderer->getFilePaths());
        
        $removed_paths = $renderer->removeLastNPaths(1);
        $this->assertEquals($expected_file_paths1, $renderer->getFilePaths());
        $this->assertEquals(array_slice($original_file_paths, -1, 1), $removed_paths);

        $removed_paths = $renderer->removeLastNPaths(5);
        $this->assertEquals($expected_file_paths2, $renderer->getFilePaths());
        $this->assertEquals(array_slice($original_file_paths, -6, 5), $removed_paths);
    }
    
    public function testThatNormalizeFolderPathWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt');

        $this->assertEquals("C:\\Windows", $renderer->normalizeFolderPathPublic('C:\\Windows\\'));        
        $this->assertEquals("/var/www/html", $renderer->normalizeFolderPathPublic('/var/www/html/'));        
    }
    
    public function testThatGetVarTypeWorksAsExpected() {
        
        $renderer = new FileRendererWrapper('file.txt');
        
        //object
        $this->assertEquals("Rotexsoft\\FileRenderer\\Tests\\FileRendererWrapper", $renderer->getVarTypePublic($renderer));        
        $this->assertEquals("Rotexsoft\\FileRenderer\\Tests\\FileRendererWrapper", $renderer->getVarTypePublic($renderer, true));        

        //string
        $this->assertEquals("string", $renderer->getVarTypePublic('sfff')); 
        $this->assertEquals("String", $renderer->getVarTypePublic('sfff', true)); 

        //array
        $this->assertEquals("array", $renderer->getVarTypePublic([])); 
        $this->assertEquals("Array", $renderer->getVarTypePublic([], true)); 

        //boolean
        $this->assertEquals("boolean", $renderer->getVarTypePublic(false)); 
        $this->assertEquals("Boolean", $renderer->getVarTypePublic(false, true)); 

        //int
        $this->assertEquals("integer", $renderer->getVarTypePublic(123)); 
        $this->assertEquals("Integer", $renderer->getVarTypePublic(123, true)); 

        //float a.k.a double
        $this->assertEquals("double", $renderer->getVarTypePublic(123.456)); 
        $this->assertEquals("Double", $renderer->getVarTypePublic(123.456, true));

        //resource
        $temp = tmpfile();
        $this->assertEquals("resource", $renderer->getVarTypePublic($temp)); 
        $this->assertEquals("Resource", $renderer->getVarTypePublic($temp, true));
        fclose($temp); // this removes the file
    }
    
    public function testThatLocateFileWorksAsExpected() {
    
        $file_name = 'fizaile';
        $data = ['a'=>'b'];
        $file_paths = [__DIR__.'/sample-views', __DIR__.'/sample-views/sub1', __DIR__.'/sample-views/sub1/sub2'];
        $renderer = new FileRendererWrapper($file_name, $data, $file_paths);
        
        $this->assertEquals(__DIR__.'/sample-views/sub1/sub2/view2.php', $renderer->locateFile(__DIR__.'/sample-views/sub1/sub2/view2.php'));
        $this->assertEquals(__DIR__.'/sample-views/sub1/sub2/view2.php', $renderer->locateFile('view2.php'));
        $this->assertEquals(__DIR__.'/sample-views/sub1/view1.php', $renderer->locateFile('view1.php'));
        $this->assertEquals(__DIR__.'/sample-views/view0.php', $renderer->locateFile('view0.php'));
        $this->assertEquals(__DIR__.'/sample-views/view.php', $renderer->locateFile('view.php'));
        $this->assertEquals('', $renderer->locateFile('non_existent.php'));    
    }
    
    public function testThatRenderToStringWorksAsExpected() {
    
        $file_name = 'view.php';
        $data = ['var1'=>'var1 at construct'];
        $file_paths = [__DIR__.'/sample-views', __DIR__.'/sample-views/sub1', __DIR__.'/sample-views/sub1/sub2'];
        $renderer = new FileRendererWrapper($file_name, $data, $file_paths);
        
        //make sure $renderer->file_name is used when renderToString()
        //is called with no args.
        $this->assertEquals($data['var1'], $renderer->renderToString());
        
        //renderer with empty $renderer->file_name
        $renderer = new FileRendererWrapper('', $data, $file_paths);
        
        //make sure file name passed to renderToString() is used when 
        //$renderer->file_name is empty.
        $this->assertEquals($data['var1'], $renderer->renderToString('view.php'));
    }
    
    
    public function testThatDoRenderWorksAsExpected() {
    
        $data = [ 'var1'=>'var1 at construct' ];
        $ds = DIRECTORY_SEPARATOR;
        $renderer = new FileRendererWrapper();

        $this->assertEquals(
            $data['var1'], 
            $renderer->doRenderPublic(__DIR__."{$ds}sample-views{$ds}view.php", $data)
        );
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Exception thrown from exception-throwing-view.php');
        
        //renderer a file that throws exception
        $renderer->doRenderPublic(__DIR__."{$ds}sample-views{$ds}exception-throwing-view.php", []);
        
        
    }
    
    public function testThat__ToStringWorksAsExpected() {

        // Test the rendering of other renderers associated with the current renderer
        $recursive_path = __DIR__.DIRECTORY_SEPARATOR.'sample-views'.DIRECTORY_SEPARATOR.'recursive-tostring';
        $layout_renderer = new FileRendererWrapper('layout.php', [], [$recursive_path]);
        $page_renderer = new FileRendererWrapper('layout_content.php', [], [$recursive_path]);
        $page_renderer2 = new FileRendererWrapper('layout_content_1.php', [], [$recursive_path]);
        $page_renderer3 = new FileRendererWrapper('layout_content_2.php', [], [$recursive_path]);
        

        $layout_renderer->layout_content= $page_renderer;
        $page_renderer->layout_content_1= $page_renderer2;
        $page_renderer2->layout_content_2= $page_renderer3;
        
        $expected_output = <<<INPUT
<!DOCTYPE html>
<html>
    <head>
        <title>Two Step View Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div>
                        <p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>
        </div>
    </body>
</html>

INPUT;
        
        $expected_output2 = <<<INPUT
            <p>This is a sample page to be injected into <strong>layout.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>

INPUT;
        
        $expected_output3 = <<<INPUT
            <p>This is a sample page to be injected into <strong>layout_content.php</strong>.</p>
                        <p>This is a sample page to be injected into <strong>layout_content_1.php</strong>.</p>

INPUT;
        
        static::assertEquals(
            $expected_output, 
            $layout_renderer->__toString()
        );
        
        
        static::assertEquals(
            $expected_output2, 
            $page_renderer->__toString()
        );
        
        static::assertEquals(
            $expected_output3, 
            $page_renderer2->__toString()
        );
    }
    
    public function testThatRenderToScreenWorksAsExpected() {
    
        $file_name = 'view.php';
        $data = ['var1'=>'var1 at construct'];
        $file_paths = [__DIR__.'/sample-views', __DIR__.'/sample-views/sub1', __DIR__.'/sample-views/sub1/sub2'];
        $renderer = new FileRendererWrapper($file_name, $data, $file_paths);
        
        //capture result via output buffering since renderToScreen() echos output instead of 
        //returning it
        ob_start();
        $renderer->renderToScreen();
        $result = ob_get_clean();
        
        //make sure $renderer->file_name is used when renderToScreen()
        //is called with no args.
        $this->assertEquals($data['var1'], $result);
        
        //renderer with empty $renderer->file_name
        $renderer = new FileRendererWrapper('', $data, $file_paths);
        
        //capture result via output buffering since renderToScreen() echos output instead of 
        //returning it
        ob_start();
        $renderer->renderToScreen('view.php');
        $result = ob_get_clean();
        
        //make sure file name passed to renderToScreen() is used when 
        //$renderer->file_name is empty.
        $this->assertEquals($data['var1'], $result);
    }

    public function testThatExceptionIsThrownWhenNonExistentFileNameIsPassedToRenderToString() {
        
        $this->expectException(\Rotexsoft\FileRenderer\FileNotFoundException::class);
        
        $renderer = new FileRendererWrapper('file.txt');
        $renderer->renderToString('non-existent-file.php');
    }

    public function testExceptionMessageWhenNonExistentFileNameIsPassedToRenderToString(){
        
        $expected_msg = <<<EOT
ERROR: Could not load the file named `non-existent-file.php` from any of the paths below:
/a
/b
/c

Rotexsoft\FileRenderer\Tests\FileRendererWrapper::renderToString(...).

EOT;
        try {
            $file_paths = ['/a', '/b', '/c'];
            $renderer = new FileRendererWrapper('test.txt', [], $file_paths);
            $renderer->renderToString('non-existent-file.php');
            
            //if the call to locateFile above did not throw an exception, then this test should fail
            $message = __FUNCTION__. '(): Expected exception not thrown when rendering file with an'
                                   . ' invalid (non-string) file name';
            throw new \Exception($message);
            
        } catch (\Exception $e) {

            $this->assertEquals($expected_msg, $e->getMessage());
        }
    }
    
    public function testThatEscapeDataWorksAsExpectedHashAlgoSha512() {
        
        // This iteration will use Sha512 inside escapeData to hash all data arrays
        // because \RendererTest::$hash_algo_index will have a value of 0
        // see \Rotexsoft\FileRenderer::hash_algos() in ./tests/bootstrap.php
        
        $this->executeEscapeDataTests();
    }
    
    public function testThatEscapeDataWorksAsExpectedHashAlgoSha384() {
        
        // This iteration will use Sha512 inside escapeData to hash all data arrays
        // because \RendererTest::$hash_algo_index will have a value of 1
        // see \Rotexsoft\FileRenderer::hash_algos() in ./tests/bootstrap.php
        
        $this->executeEscapeDataTests();
    }
    
    public function testThatEscapeDataWorksAsExpectedHashAlgoSha256() {
        
        // This iteration will use Sha512 inside escapeData to hash all data arrays
        // because \RendererTest::$hash_algo_index will have a value of 2
        // see \Rotexsoft\FileRenderer::hash_algos() in ./tests/bootstrap.php
        
        $this->executeEscapeDataTests();
    }
    
    public function testThatEscapeDataWorksAsExpectedHashAlgoSha1() {
        
        // This iteration will use Sha512 inside escapeData to hash all data arrays
        // because \RendererTest::$hash_algo_index will have a value of 3
        // see \Rotexsoft\FileRenderer::hash_algos() in ./tests/bootstrap.php
        
        $this->executeEscapeDataTests();
    }
    
    public function testThatEscapeDataWorksAsExpectedSha512() {
        
        $this->executeEscapeDataTests();
    }
    
    protected function executeEscapeDataTests() {
    
        $file_name = 'view.php';
        
        $html_2_escape = '<script>alert("zf2")</script>';
        $expected_escaped_html = '&lt;script&gt;alert(&quot;zf2&quot;)&lt;/script&gt;';
        //html, html attr, css and js escapes applied
        $expected_escaped_html_4_escapes = '\x5C26\x20amp\x5C3B\x20lt\x5C26\x20\x5C23\x20x3B\x5C3B\x20script\x5C26\x20amp\x5C3B\x20gt\x5C26\x20\x5C23\x20x3B\x5C3B\x20alert\x5C26\x20\x5C23\x20x28\x5C3B\x20\x5C26\x20amp\x5C3B\x20quot\x5C26\x20\x5C23\x20x3B\x5C3B\x20zf2\x5C26\x20amp\x5C3B\x20quot\x5C26\x20\x5C23\x20x3B\x5C3B\x20\x5C26\x20\x5C23\x20x29\x5C3B\x20\x5C26\x20amp\x5C3B\x20lt\x5C26\x20\x5C23\x20x3B\x5C3B\x20\x5C26\x20\x5C23\x20x2F\x5C3B\x20script\x5C26\x20amp\x5C3B\x20gt\x5C26\x20\x5C23\x20x3B\x5C3B\x20';
        
        $html_attr_2_escape = <<<INPUT
faketitle onmouseover=alert(/ZF2!/);
INPUT;
        $expected_escaped_html_attr = 'faketitle&#x20;onmouseover&#x3D;alert&#x28;&#x2F;ZF2&#x21;&#x2F;&#x29;&#x3B;';
        //html attr, css and js escapes applied
        $expected_escaped_html_attr_3_escapes = 'faketitle\x5C26\x20\x5C23\x20x20\x5C3B\x20onmouseover\x5C26\x20\x5C23\x20x3D\x5C3B\x20alert\x5C26\x20\x5C23\x20x28\x5C3B\x20\x5C26\x20\x5C23\x20x2F\x5C3B\x20ZF2\x5C26\x20\x5C23\x20x21\x5C3B\x20\x5C26\x20\x5C23\x20x2F\x5C3B\x20\x5C26\x20\x5C23\x20x29\x5C3B\x20\x5C26\x20\x5C23\x20x3B\x5C3B\x20';
        
        $css_2_escape = <<<INPUT
body {
    background-image: url('http://example.com/foo.jpg?</style><script>alert(1)</script>');
}
INPUT;
        $expected_escaped_css = 'body\20 \7B \A \20 \20 \20 \20 background\2D image\3A \20 url\28 \27 http\3A \2F \2F example\2E com\2F foo\2E jpg\3F \3C \2F style\3E \3C script\3E alert\28 1\29 \3C \2F script\3E \27 \29 \3B \A \7D';
        //css and js escapes applied
        $expected_escaped_css_2_escapes = 'body\x5C20\x20\x5C7B\x20\x5CA\x20\x5C20\x20\x5C20\x20\x5C20\x20\x5C20\x20background\x5C2D\x20image\x5C3A\x20\x5C20\x20url\x5C28\x20\x5C27\x20http\x5C3A\x20\x5C2F\x20\x5C2F\x20example\x5C2E\x20com\x5C2F\x20foo\x5C2E\x20jpg\x5C3F\x20\x5C3C\x20\x5C2F\x20style\x5C3E\x20\x5C3C\x20script\x5C3E\x20alert\x5C28\x201\x5C29\x20\x5C3C\x20\x5C2F\x20script\x5C3E\x20\x5C27\x20\x5C29\x20\x5C3B\x20\x5CA\x20\x5C7D\x20';
        
        $js_2_escape = <<<INPUT
bar&quot;; alert(&quot;Meow!&quot;); var xss=&quot;true
INPUT;
        $expected_escaped_js = 'bar\x26quot\x3B\x3B\x20alert\x28\x26quot\x3BMeow\x21\x26quot\x3B\x29\x3B\x20var\x20xss\x3D\x26quot\x3Btrue';
    
        $data = [
            'html' => $html_2_escape,
            'html_attr' => $html_attr_2_escape,
            'css' => $css_2_escape,
            'js' => $js_2_escape,
            'no_escape_variable' => 'yabadabadoo!',
        ];
        $original_data = $data;

        $renderer = new FileRendererWrapper($file_name, $data);
        $renderer_no_encoding = (new FileRendererWrapper($file_name, $data))
                                                    ->setEscapeEncoding('');
        
        //scenario where empty data array is passed
        $empty_data = [];
        $original_empty_data = $empty_data;
        $renderer->escapeDataPublic($empty_data);
        $this->assertEquals($original_empty_data, $empty_data);
        
        //test one 'iso-8859-1' scenaario
        $renderer->escapeDataPublic($data, 'iso-8859-1', ['html'], ['html_attr'], ['css'], ['js']);
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        //other utf-8 scenarios
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', ['html'], ['html_attr'], ['css'], ['js']);
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        $data = $original_data;
        $renderer_no_encoding->escapeDataPublic($data, '', ['html'], ['html_attr'], ['css'], ['js']);
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        ///////////////////////
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', ['html']);
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($original_data['html_attr'], $data['html_attr']);
        $this->assertStringContainsString($original_data['css'], $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        ///////////////////////
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], ['html_attr']);
        $this->assertStringContainsString($original_data['html'], $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($original_data['css'], $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        ///////////////////////
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], [], ['css']);
        $this->assertStringContainsString($original_data['html'], $data['html']);
        $this->assertStringContainsString($original_data['html_attr'], $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        /////////////////////// only js escape should be applied
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], [], [], ['js']);
        $this->assertStringContainsString($original_data['html'], $data['html']);
        $this->assertStringContainsString($original_data['html_attr'], $data['html_attr']);
        $this->assertStringContainsString($original_data['css'], $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        /////////////////////// only html escape should be applied
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', ['html'], ['html'], ['html'], ['html']);
        $this->assertStringContainsString($expected_escaped_html_4_escapes, $data['html']);
        $this->assertStringContainsString($original_data['html_attr'], $data['html_attr']);
        $this->assertStringContainsString($original_data['css'], $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        /////////////////////// only html attr escape should be applied
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], ['html_attr'], ['html_attr'], ['html_attr']);
        $this->assertStringContainsString($original_data['html'], $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr_3_escapes, $data['html_attr']);
        $this->assertStringContainsString($original_data['css'], $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        /////////////////////// only css escape should be applied
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], [], ['css'], ['css']);
        $this->assertStringContainsString($original_data['html'], $data['html']);
        $this->assertStringContainsString($original_data['html_attr'], $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css_2_escapes, $data['css']);
        $this->assertStringContainsString($original_data['js'], $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        /////////////////////// add sub-array
        $data = $original_data;
        $data['sub_array'] = $data;
        $renderer->escapeDataPublic($data, 'utf-8', ['html'], ['html_attr'], ['css'], ['js']);
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        $this->assertStringContainsString($expected_escaped_html, $data['sub_array']['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['sub_array']['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['sub_array']['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['sub_array']['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['sub_array']['no_escape_variable']);
        
        //test that calling escapeData the second time with the same data array and escape parameters 
        //does not lead to double escaping
        $renderer->escapeDataPublic($data, 'utf-8', ['html'], ['html_attr'], ['css'], ['js']);
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['no_escape_variable']);
        
        $this->assertStringContainsString($expected_escaped_html, $data['sub_array']['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['sub_array']['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['sub_array']['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['sub_array']['js']);
        $this->assertEquals($original_data['no_escape_variable'], $data['sub_array']['no_escape_variable']);
        
        /////////////////////// Test wild card
        //html escape all data fields
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', ['*']);
        
        $expected_escaped_html = '&lt;script&gt;alert(&quot;zf2&quot;)&lt;/script&gt;';
        $expected_escaped_html_attr = 'faketitle onmouseover=alert(/ZF2!/);';
        $expected_escaped_css = <<<INPUT
body {
    background-image: url(&#039;http://example.com/foo.jpg?&lt;/style&gt;&lt;script&gt;alert(1)&lt;/script&gt;&#039;);
}
INPUT;
        $expected_escaped_js = 'bar&amp;quot;; alert(&amp;quot;Meow!&amp;quot;); var xss=&amp;quot;true';
        $expected_escaped_5th_field = "yabadabadoo!";
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($expected_escaped_5th_field, $data['no_escape_variable']);
      
        //html attr escape all data fields
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], ['*']);
        
        $expected_escaped_html = '&lt;script&gt;alert&#x28;&quot;zf2&quot;&#x29;&lt;&#x2F;script&gt;';
        $expected_escaped_html_attr = 'faketitle&#x20;onmouseover&#x3D;alert&#x28;&#x2F;ZF2&#x21;&#x2F;&#x29;&#x3B;';
        $expected_escaped_css = <<<INPUT
body&#x20;&#x7B;&#x0A;&#x20;&#x20;&#x20;&#x20;background-image&#x3A;&#x20;url&#x28;&#x27;http&#x3A;&#x2F;&#x2F;example.com&#x2F;foo.jpg&#x3F;&lt;&#x2F;style&gt;&lt;script&gt;alert&#x28;1&#x29;&lt;&#x2F;script&gt;&#x27;&#x29;&#x3B;&#x0A;&#x7D;
INPUT;
        $expected_escaped_js = 'bar&amp;quot&#x3B;&#x3B;&#x20;alert&#x28;&amp;quot&#x3B;Meow&#x21;&amp;quot&#x3B;&#x29;&#x3B;&#x20;var&#x20;xss&#x3D;&amp;quot&#x3B;true';
        $expected_escaped_5th_field = "yabadabadoo&#x21;";
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($expected_escaped_5th_field, $data['no_escape_variable']);
        
        //css escape all data fields
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], [], ['*']);
        
        $expected_escaped_html = '\3C script\3E alert\28 \22 zf2\22 \29 \3C \2F script\3E ';
        $expected_escaped_html_attr = 'faketitle\20 onmouseover\3D alert\28 \2F ZF2\21 \2F \29 \3B ';
        $expected_escaped_css = 'body\20 \7B \A \20 \20 \20 \20 background\2D image\3A \20 url\28 \27 http\3A \2F \2F example\2E com\2F foo\2E jpg\3F \3C \2F style\3E \3C script\3E alert\28 1\29 \3C \2F script\3E \27 \29 \3B \A \7D ';
        $expected_escaped_js = 'bar\26 quot\3B \3B \20 alert\28 \26 quot\3B Meow\21 \26 quot\3B \29 \3B \20 var\20 xss\3D \26 quot\3B true';
        $expected_escaped_5th_field = 'yabadabadoo\21 ';
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($expected_escaped_5th_field, $data['no_escape_variable']);
       
        //js escape all data fields
        $data = $original_data;
        $renderer->escapeDataPublic($data, 'utf-8', [], [], [], ['*']);
        
        $expected_escaped_html = '\x3Cscript\x3Ealert\x28\x22zf2\x22\x29\x3C\x2Fscript\x3E';
        $expected_escaped_html_attr = 'faketitle\x20onmouseover\x3Dalert\x28\x2FZF2\x21\x2F\x29\x3B';
        $expected_escaped_css = 'body\x20\x7B\x0A\x20\x20\x20\x20background\x2Dimage\x3A\x20url\x28\x27http\x3A\x2F\x2Fexample.com\x2Ffoo.jpg\x3F\x3C\x2Fstyle\x3E\x3Cscript\x3Ealert\x281\x29\x3C\x2Fscript\x3E\x27\x29\x3B\x0A\x7D';
        $expected_escaped_js = 'bar\x26quot\x3B\x3B\x20alert\x28\x26quot\x3BMeow\x21\x26quot\x3B\x29\x3B\x20var\x20xss\x3D\x26quot\x3Btrue';
        $expected_escaped_5th_field = 'yabadabadoo\x21';
        
        $this->assertStringContainsString($expected_escaped_html, $data['html']);
        $this->assertStringContainsString($expected_escaped_html_attr, $data['html_attr']);
        $this->assertStringContainsString($expected_escaped_css, $data['css']);
        $this->assertStringContainsString($expected_escaped_js, $data['js']);
        $this->assertEquals($expected_escaped_5th_field, $data['no_escape_variable']);
    }
    
    public function testThatEscapeHtmlWorksAsExpected() {
        $file_name = 'view.php';
        
        $html_2_escape = '<script>alert("zf2")</script>';
        $expected_escaped_html = '&lt;script&gt;alert(&quot;zf2&quot;)&lt;/script&gt;';

        $renderer = new FileRendererWrapper($file_name, [], [], 'utf-8');
        $this->assertStringContainsString($expected_escaped_html, $renderer->escapeHtml($html_2_escape));
    }
    
    public function testThatEscapeHtmlAttrWorksAsExpected() {
        $file_name = 'view.php';

        $html_attr_2_escape = <<<INPUT
faketitle onmouseover=alert(/ZF2!/);
INPUT;
        $expected_escaped_html_attr = 'faketitle&#x20;onmouseover&#x3D;alert&#x28;&#x2F;ZF2&#x21;&#x2F;&#x29;&#x3B;';

        $renderer = new FileRendererWrapper($file_name, [], [], 'utf-8');
        $this->assertStringContainsString($expected_escaped_html_attr, $renderer->escapeHtmlAttr($html_attr_2_escape));
    }
    
    public function testThatEscapeCssWorksAsExpected() {
        $file_name = 'view.php';

        $css_2_escape = <<<INPUT
body {
    background-image: url('http://example.com/foo.jpg?</style><script>alert(1)</script>');
}
INPUT;
        $expected_escaped_css = 'body\20 \7B \A \20 \20 \20 \20 background\2D image\3A \20 url\28 \27 http\3A \2F \2F example\2E com\2F foo\2E jpg\3F \3C \2F style\3E \3C script\3E alert\28 1\29 \3C \2F script\3E \27 \29 \3B \A \7D';

        $renderer = new FileRendererWrapper($file_name, [], [], 'utf-8');
        $this->assertStringContainsString($expected_escaped_css, $renderer->escapeCss($css_2_escape));
    }
    
    public function testThatEscapeJsWorksAsExpected() {
        $file_name = 'view.php';

        $js_2_escape = <<<INPUT
bar&quot;; alert(&quot;Meow!&quot;); var xss=&quot;true
INPUT;
        $expected_escaped_js = 'bar\x26quot\x3B\x3B\x20alert\x28\x26quot\x3BMeow\x21\x26quot\x3B\x29\x3B\x20var\x20xss\x3D\x26quot\x3Btrue';

        $renderer = new FileRendererWrapper($file_name, [], [], 'utf-8');
        $this->assertStringContainsString($expected_escaped_js, $renderer->escapeJs($js_2_escape));
    }
    
    public function testThatEscapeUrlWorksAsExpected() {
        $file_name = 'view.php';
                
        $url_2_escape =  <<<INPUT
" onmouseover="alert('zf2')
INPUT;
        $expected_escaped_url = '%22%20onmouseover%3D%22alert%28%27zf2%27%29';

        $renderer = new FileRendererWrapper($file_name, [], [], 'utf-8');
        $this->assertEquals($expected_escaped_url, $renderer->escapeUrl($url_2_escape));
    }
}
