<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Yangqi\Htmldom\Htmldom;

class AdminController extends HomeController
{
    //
    public function __construct(){
    	
    	$this->middleware('admin_auth');
    	$this->data['body'] = 'layouts.admin.pages.index';
    }

    public function index(){
    	$this->data['content'] = 'layouts.admin.pages.local.index';    	
    	return $this->output('admin',false);
    }

    protected function parser_xml(){
    	#dd(json_decode(json_encode((array)simplexml_load_string(file_get_contents('http://www.bbc.com/vietnamese/index.xml'))),1));
    }


    public function test(){
    	$xml = new \SimpleXMLElement(file_get_contents('http://www.bbc.com/vietnamese/index.xml'));
    	$data = NULL;    	
    	$html = new Htmldom();
		foreach($xml->entry as $key => $val){
			
			$link = (string)$val->link['href'];
			$obj = $html->file_get_html($link);
			if(!isset($obj->find('div[property=articleBody]')[0])){
				$body = $obj->find('div.map-body')[0]->outertext;
			}else{
				$body = $obj->find('.story-body__inner')[0]->outertext;
			}
			$data[$link]['content'] = $body;
			$data[$link]['title'] = (string)$val->title;
			$data[$link]['description'] = (string)$val->summary;
			$data[$link]['category'] = (string)$val->category[1]['label'];
			$data[$link]['image'] = $obj->find('meta[property=og:image]')[0]->content;	
		}		
		dd($data);
		#dd($curl->get(array_keys($data)[0],"://",30,0));

		#$this->data['data'] = $data ;
    	$this->data['content'] = 'layouts.admin.pages.local.test';
    	return $this->output('admin',false);	
    }
}
