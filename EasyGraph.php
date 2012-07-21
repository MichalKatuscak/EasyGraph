<?php

namespace EasyGraphs {

    /**
     * Work with SVG 
     */
    final class SVG
    {
        /** @var string */
        private $canvas;
        
        /**
         * Create SVG canvas
         * 
         * @param type $style 
         */
        public function __construct($style='') {
            
            $this->canvas = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                style="'.$style.'">';
            
        }
        
        /**
         * Return SVG canvas
         * 
         * @return string 
         */
        public function getCanvas() {
            
            return $this->canvas . '</svg>';
            
        }
        
        /**
         * Create <rect>
         * 
         * @param int $width
         * @param int $height
         * @param int $x
         * @param int $y 
         * @param string $style 
         * @param string $actions
         */
        public function addRect($width, $height, $x, $y, $style='', $actions='') {
            
            $this->canvas .= '<rect width="'.$width.'" height="'.$height.'" x="'.$x.'" y="'.$y.'"
                style="'.$style.'" '.$actions.'/>';
            
        }
        
        /**
         * Create <circle>
         * 
         * @param int $r
         * @param int $x
         * @param int $y
         * @param string $style 
         * @param string $actions 
         */
        public function addCircle($r, $x, $y, $style='', $actions='') {
            
            $this->canvas .= '<circle cx="'.$x.'" cy="'.$y.'" r="3" 
                    style="'.$style.'" '.$actions.'/>';
                  
        }
        
        /**
         * Create <text>
         * 
         * @param string $text
         * @param int $x
         * @param int $y
         * @param string $style 
         * @param string $actions 
         */
        public function addText($text, $x, $y, $style='', $actions='') {
            
            $this->canvas .= '<text x="'.$x.'" y="'.$y.'"
                style="'.$style.'" '.$actions.'>'. $text .'</text>';
                 
        }
        
        /**
         * Create <linne>
         * 
         * @param int $x1
         * @param int $y1
         * @param int $x2
         * @param int $y2
         * @param string $style 
         * @param string $actions 
         */
        public function addLine($x1, $y1, $x2, $y2, $style='', $actions='') {
            
            $this->canvas .= '<line x1="'.$x1.'" y1="'.$y1.'" 
                x2="'.$x2.'" y2="'.$y2.'" 
                style="'.$style.'" '.$actions.'/>';
                     
        }
        
    }

    /**
     * Settings for all graphs 
     */
    abstract class Graph
    {
        
        public $width = '600';
        public $height = '200';
        protected $data = Array();
        
        /**
         * Add data to graphs
         * 
         * @param array $data 
         */
        public function __construct($data) {
            
            if (is_array($data)) {
                
                $this->data = $data;
                
            }
            
        }
        
    }
    
    /**
     * Line graph
     */
    final class Line extends Graph
    {
              
        /**
         * Render current graph
         * 
         * @return string SVG
         */
        public function render() {
            
                // Create canvas
            $svg = new SVG('width:'.$this->width.'px;height:'.$this->height.'px;');
            
                // Padding
            $start_left = 10 * strlen(max($this->data));
            $start_top = 20;
            $start_bottom = 20;
            $start_right = 30;
            
                // Real width and height of graph
            $real_width = $this->width - $start_left - $start_right;
            $real_height = $this->height - $start_top - $start_bottom;
            
                // Set spacings between points
            $spacing = ($this->width-$start_left-$start_right) / (count($this->data)-1);
            
                // Border
            $svg->addRect($real_width, $real_height, $start_left, $start_top,
                    'stroke: #ddd;stroke-width: 1;fill:#fff');
            
                // Show zero
            $svg->addText('0', ($start_left-6), ($this->height-$start_bottom-1),
                    'fill: #000; font: sans-serif;font-size: 12px;text-anchor:end;');
            
                // Show max value
            $svg->addText(max($this->data), ($start_left-6), ($start_top+12),
                    'fill: #000; font: sans-serif;font-size: 12px;text-anchor:end;');
            
            $point = $real_height/max($this->data);
            
            $i = 0;
            $last_point = 0;
            
            foreach ($this->data as $name=>$d) {
                
                    // Define position
                $x = round($i*$spacing)+$start_left;
                $y = $this->height-round($point*$d)-$start_bottom;
                
                    // Show value names
                $svg->addText($name, $x, ($this->height-$start_bottom+15),
                    'fill: #000; font: sans-serif;font-size: 12px;text-anchor:middle;');
                
                    // Show value
                $svg->addText($d, $x, ($start_top-6),
                    'fill: #000; font: sans-serif;font-size: 12px;text-anchor:middle;display:none;',
                    'id="'.$x.'"');
                
                    // Show grid
                $svg->addLine($x, ($start_top), $x, ($this->height-$start_bottom),
                    'stroke: #ddd; stroke-width: 2;',
                    'onmouseover="document.getElementById(\''.$x.'\').style.display=\'block\'" onmouseout="document.getElementById(\''.$x.'\').style.display=\'none\'"');
                
                    // Show line (connect points)
                if (is_array($last_point)) {
                    
                    $svg->addLine($last_point[0], $last_point[1], $x, $y,
                        'stroke: #999; stroke-width: 2;');
                    
                }
                
                    // Show point
                $svg->addCircle(3, $x, $y, 'stroke: black;stroke-width: 1;fill: #000;',
                        'onmouseover="document.getElementById(\''.$x.'\').style.display=\'block\'" 
                         onmouseout="document.getElementById(\''.$x.'\').style.display=\'none\'"');
                
                    // Save last point
                $last_point = array($x,$y);
                
                $i++;
                
            } 
            
            return $svg->getCanvas();
            
        }
        
    }
    
}