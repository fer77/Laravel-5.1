<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function show($id)
    {
    	// auth()->logout();
    	auth()->loginUsingId(1); //temp

    	$post = Post::findOrFail($id);

    	// $this->authorize('show-post', $post);

    	// if (Gate::denies('show-post', $post)) {
    	// 	abort(403, 'Sorry, not sorry.');
    	// }
    	
    	// Auth::user()->can('update-post', $post);

    	return view('posts.show', compact('post'));
    }
}
