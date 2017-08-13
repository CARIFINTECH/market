<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
class HomeController extends BaseController
{
    const MAX_CHILDREN = 10;

    protected $layout = 'layouts.home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base=$this->baseAndFirstChildren();
        return view('home',['base' => $base]);
    }
    
    public function baseAndFirstChildren(){
        $base = Category::where('parent_id',0)->get();
        $children = array();
        $j = 0;
        foreach ($base as $cat) {
            $cat->class = "category-$j";
            $cat->children = $cat->children()->limit(10)->get(); 
            $j++;
        }
        return $base;
    }
}
