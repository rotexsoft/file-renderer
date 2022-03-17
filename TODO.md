* ~~Implement data sharing between layouts and page content view:~~
    ~~- Will need to think about how that should work.~~
    ~~- I am thinking of adding code to __set to copy the data fields from $this to the Renderer object being assigned.~~
    ~~- For example if you have $layout_renderer and $view_renderer and you do some thing like $layout_renderer->content = $view_renderer;
      All the data attributes in $layout_renderer should get copied to $view_renderer.~~
    ~~- I should also add a __toString() method to the Renderer class to support this.~~
    ~~- Would need to test the nesting of $this when a Renderer is assigned as one of the data values of this.~~
        - Decided to implement functionality in **Rotexsoft\FileRenderer\Renderer::__toString()** that invokes **__toString()**
          automatically on all instances of **Rotexsoft\FileRenderer\Renderer** inside the **$this->data** property recursively