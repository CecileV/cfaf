<?php

use Illuminate\Database\Seeder;
use App\Article;
use App\Category;
use App\Tag;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 5 ; $i++) { 
			$model = new Article();
	        $model->title = 'Article '.$i;
	        $model->slug = 'article-'.$i;
            $model->draft = '0';
            $model->created_by = '1';
            $model->picture = 'http://fakeimg.pl/350x200/';
	        $model->content = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id fermentum dui. Donec non urna dictum, accumsan lectus at, malesuada massa. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas scelerisque lorem purus, ac bibendum turpis ullamcorper quis. Donec sit amet maximus erat, a imperdiet nisl. Aliquam eu dictum magna, eu hendrerit velit. Vivamus eget condimentum justo. Donec porttitor commodo nisi, vitae tempus lorem facilisis quis. Aenean ultricies eget nibh nec pharetra.</p>
	        <p>Donec tincidunt, orci eu accumsan ornare, erat purus luctus ex, at dapibus velit ex ut sapien. Aliquam finibus hendrerit nunc in consequat. Mauris dictum sapien nec enim consectetur, id volutpat mauris scelerisque. In id lobortis nunc. Duis id arcu eros. Nunc molestie mollis sagittis. Quisque luctus, ipsum sed vulputate pulvinar, erat justo dictum est, vitae finibus mauris libero eget justo. Cras ornare leo vitae lorem cursus aliquet. In tortor nibh, sollicitudin non consequat non, posuere sed ex. Praesent eu commodo ex. Curabitur metus ligula, scelerisque sit amet tincidunt condimentum, vehicula eu arcu. Nunc congue quam ut mauris commodo, in pretium risus iaculis. Duis accumsan purus a tempus volutpat. Ut quis mollis massa, et ullamcorper lectus. In auctor luctus nisi ultricies viverra.</p> ';
			$model->save();

            $category = Category::where('slug', 'category'.$i)->first();
            $tag = Tag::where('slug','tag'.$i)->first();
            if(!empty($category)){
                $model->categories()->attach($category);
            }
            if(!empty($tag)){
                $model->tags()->attach($tag);
            }
    	}
    }
}
