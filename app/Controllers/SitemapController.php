<?php

namespace App\Controllers;

class SitemapController extends BaseController {
    
    public static $FILE_NAME = 'sitemap.xml';

    public function __construct() {
        $this->page = new \App\Models\PageModel();
        $this->news = new \App\Models\NewsModel();
        helper('xml');
    }
    
    public function generate(){
        $s = '<?xml version="1.0" encoding="UTF-8"?>'
                . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        $s .= $this->get_xml_part([0 => ["url" => ""]], "1", 'weekly');
        $s .= $this->get_xml_part($this->page->findAll(), "0.6");
        $s .= $this->get_xml_part($this->news->findAll(), "0.5");
        $s .= '</urlset>';

        file_put_contents(self::$FILE_NAME, $s); 
        
        return xml_convert($s);
    }
    
    public function get_xml_part($list, $priority, $freg = 'monthly'){
        $r = '';
        foreach ($list as $el){
            $r .= '<url>'
                    . '<loc>' . base_url() . $el['url'] . '</loc>'
                    . '<priority>' . $priority . '</priority>'
                    . '<changefreq>' . $freg . '</changefreq>';
            if(isset($el['updated_at'])){
                $r .= '<lastmod>' . $el['updated_at'] . '</lastmod>';
            }
            $r .= '</url>';
        }
        return $r;
    }

}