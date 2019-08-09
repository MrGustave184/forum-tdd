<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

		public function __construct()
		{
			// $this->middleware('auth')->only(['store', 'create']);
			$this->middleware('auth')->Except(['index', 'show']);
		}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {	
				/**
				* The class not found error came because route model binding was trying to get the channel
				*	by his id, but we are using the slug instead (in the url)
				*/
				// // For this approach, we pass $channelSlug = null as a parameter
				// if($channelSlug) {
				// 	$channel = Channel::where('slug', $channelSlug)->first();
				// 	$threads = Thread::where('channel_id', $channel->id)->latest()->get();
				// }
				// else {
				// 	$threads = Thread::latest()->get();
				// }

				// // For this approach, we use route model binding and the eloquent relationship
				// if($channel->exists)
				// 	$threads = $channel->threads()->latest()->get();
				// else
				// 	$threads = Thread::latest()->get();
				
				$threads = $channel->exists ? $channel->threads()->latest()->get() : Thread::latest()->get();

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
			return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
				// Validation
				$this->validate($request, [
					'title' => 'required',
					'body' => 'required',

					// channel id is required, and should exists in the channels table, id column
					'channel_id' => 'required|exists:channels,id'
				]);
				
				//  dd($request->all());
				$thread = Thread::create([
					'user_id' => auth()->id(),
					'channel_id' => request('channel_id'),
					'title' => $request->input('title'),
					'body' => $request->input('body'),
				]);

				return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
      return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
